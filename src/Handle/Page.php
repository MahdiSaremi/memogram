<?php

namespace MemoGram\Handle;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use MemoGram\Exceptions\ForcePageResponse;
use MemoGram\Exceptions\StopPage;
use MemoGram\Matching\ListenerDispatcher;
use MemoGram\Models\PageCellModel;
use MemoGram\Models\PageModel;
use MemoGram\Models\PageUseModel;
use MemoGram\Response\AsResponse;

class Page
{
    public const STATUS_NOTING = 0;
    public const STATUS_MOUNTING = 1;
    public const STATUS_HYDRATING = 2;
    public const STATUS_REFRESHING = 3;

    public array $params = [];
    public int $status = self::STATUS_NOTING;
    protected array $hydratedStates;
    /** @var State[] */
    protected array $states = [];
    protected array $namedStates = [];
    protected int $statePointer = 0;
    public PageModel $pageModel;
    public ?PageUseModel $pageUseModel = null;
    /** @var Collection<int,PageCellModel> */
    public Collection $pageCells;
    public ListenerDispatcher $topListener;
    public ListenerDispatcher $listener;
    protected bool $requireRefresh = false;
    protected bool $requireSave = false;
    protected array $watchers = [];
    protected array $lastWatcherResult = [];
    protected ?string $version = null;
    protected mixed $replacedResponse = null;

    public function __construct(
        protected string|array $reference,
    )
    {
    }

    public function refresh(): void
    {
        $this->requireRefresh = true;
    }

    public function save(): void
    {
        $this->requireSave = true;
    }

    protected function resetBasic(): void
    {
        $this->listener = new ListenerDispatcher();
        $this->topListener = new ListenerDispatcher();
        $this->watchers = [];
        $this->replacedResponse = null;
    }

    public function mount(array $params): void
    {
        $this->resetBasic();
        $this->status = self::STATUS_MOUNTING;
        $this->params = array_replace($this->params, $params);
        $this->pageModel = new PageModel();
        $this->pageCells = new Collection();
        $this->version = null;

        $this->callReference(function ($response) {
            if ($this->replacedResponse) {
                $response = $this->replacedResponse;
            }

            /**
             * @var string $key
             * @var AsResponse $response
             */
            foreach (context()->handler->normalizeResponse($response) as [$key, $response]) {
                $response->runResponse($this, $key);
            }
        });
        $this->updateDatabase();
    }

    public function hydrate(PageUseModel $use): void
    {
        $this->resetBasic();
        $this->status = self::STATUS_HYDRATING;
        $this->statePointer = 0;
        $this->pageModel = $use->page;
        $this->pageUseModel = $use;
        $this->version = $use->page->version;
        $this->pageCells = $this->pageUseModel->cells()->get();
        $this->hydratedStates = $use->page->states;

        $this->callReference(function ($response) {
            /**
             * @var string $key
             * @var AsResponse $response
             */
            foreach (context()->handler->normalizeResponse($response) as [$key, $response]) {
                $response->runListen($this);
            }
        });
    }

    public function pushHydratedEvent(Event $event, Closure $next): bool
    {
        $this->requireRefresh = false;
        $result = $this->pushHydratedEventWithoutRefreshing($event, $next);

        $this->callWatchers();

        if ($this->requireRefresh) {
            $cells = $this->pageCells;
            $this->resetBasic();
            $this->status = self::STATUS_REFRESHING;
            $this->statePointer = 0;
            $this->pageCells = new Collection();

            $this->callReference(function ($response) use ($cells) {
                /**
                 * @var string $key
                 * @var AsResponse $response
                 */
                foreach (context()->handler->normalizeResponse($response) as [$key, $response]) {
                    $response->runRefresh($this, $key, $cells->firstWhere('key', $key));
                }
            });
            $this->updateDatabase();
        } elseif ($this->requireSave) {
            $this->updateDatabaseStates();
        }

        return $result;
    }

    protected function pushHydratedEventWithoutRefreshing(Event $event, Closure $next): bool
    {
        try {
            context()->handler->pageStack[] = $this;
            if ($this->listener->pushEventAt($event, true)) {
                return true;
            }

            if ($this->topListener->pushEventAt($event, true)) {
                return true;
            }
        } finally {
            array_pop(context()->handler->pageStack);
        }

        if ($next($event)) {
            return true;
        }

        if ($this->replacedResponse) {
            /**
             * @var string $key
             * @var AsResponse $response
             */
            foreach (context()->handler->normalizeResponse($this->replacedResponse) as [$key, $response]) {
                $response->runRefresh($this, $key, $this->pageCells->firstWhere('key', $key));
            }

            return true;
        }

        try {
            context()->handler->pageStack[] = $this;
            if ($this->topListener->pushEventAt($event, false)) {
                return true;
            }

            if ($this->listener->pushEventAt($event, false)) {
                return true;
            }
        } finally {
            array_pop(context()->handler->pageStack);
        }

        return false;
    }

    public function listenUsing(Closure $callback): void
    {
        $callback($this->listener);
    }

    public function topListenUsing(Closure $callback): void
    {
        $callback($this->topListener);
    }

    public function replaceResponse($response): void
    {

    }

    public function useState($defaultValue): State
    {
        switch ($this->status) {
            case self::STATUS_MOUNTING:
                $state = new State(value($defaultValue));
                $this->states[] = $state;
                return $state;

            case self::STATUS_HYDRATING:
                if ($this->statePointer < count($this->hydratedStates)) {
                    return $this->states[$this->statePointer] = new State($this->hydratedStates[$this->statePointer++]);
                } else {
                    return $this->states[$this->statePointer++] = new State(value($defaultValue));
//                    throw new \Exception("State is not exists."); todo
                }

            case self::STATUS_REFRESHING:
                if ($this->statePointer < count($this->states)) {
                    return $this->states[$this->statePointer++];
                } else {
                    return $this->states[$this->statePointer++] = new State(value($defaultValue));
//                    throw new \Exception("State is not exists."); todo
                }

            default:
                throw new \Exception("Invalid state.");
        }
    }

    public function useWatch(Closure $callback, array $dependencyList): mixed
    {
        $this->watchers[] = [
            $callback,
            $dependencyList,
        ];

        if (isset($this->lastWatcherResult[count($this->watchers) - 1])) {
            return $this->lastWatcherResult[count($this->watchers) - 1];
        }

        return null;
    }

    public function useVersion($version, $fail = null): void
    {
        if (!is_string($version)) {
            $version = hash('crc32', serialize($version));
        } elseif (strlen($version) >= 8) {
            $version = hash('crc32', $version);
        }

        if ($this->status == self::STATUS_MOUNTING) {
            $this->version = $version;
        } else {
            if ($this->version !== $version) {
                $this->replaceResponse($fail ?? function () {
                    throw new \Exception("Version is old."); // todo
                });

                throw new StopPage();
            }
        }
    }

    public function getParam(string $name, $default = null)
    {
        return $this->params[$name] ?? value($default);
    }

    public function getParams(): array
    {
        return $this->params;
    }

    protected function callReference(Closure $callback): void
    {
        [$class, $method] = $this->getReferenceCaller();

        context()->handler->pageStack[] = $this;

        try {
            $callback(
                $class->$method(),
            );
        } catch (ForcePageResponse $pageResponse) {
            $callback(
                $pageResponse->getResponse(),
            );
        } catch (StopPage) {
            $callback(null);
        } finally {
            array_pop(context()->handler->pageStack);
        }
    }

    protected function callWatchers(): void
    {
        if (!$this->watchers) {
            return;
        }

        $changedStates = [];
        foreach ($this->states as $state) {
            if ($state->isChanged) {
                $changedStates[] = $state;
            }
        }

        foreach ($this->watchers as $watcher) {
            $ok = false;
            [$callback, $deps] = $watcher;

            foreach ($changedStates as $state) {
                if (in_array($state, $deps, true)) {
                    $ok = true;
                    break;
                }
            }

            if ($ok) {
                $callback();
            }
        }
    }

    protected function updateDatabase(): void
    {
        if ($this->pageCells->isEmpty()) {
            if (!$this->pageUseModel || !$this->pageModel->exists) {
                return;
            }

            $this->deletePageUsage($this->pageModel, $this->pageUseModel);
            return;
        }

        $states = array_map(function (State $state) {
            return $state->value;
        }, $this->states);
        $states_hash = md5(json_encode($states));

        DB::connection(config('memogram.database.connection'))->transaction(function () use ($states, $states_hash) {
            $previousPage = $this->pageModel->exists
                ? PageModel::query()
                    ->where(['reference' => $this->pageModel->reference, 'states_hash' => $this->pageModel->states_hash, 'version' => $this->pageModel->version])
                    ->lockForUpdate()
                    ->first()
                : null;

            if ($previousPage && $previousPage->states_hash == $states_hash) {
                $newPage = $previousPage;
            } elseif ($_newPage = PageModel::query()->where(['reference' => $this->getStringReference(), 'states_hash' => $states_hash, 'version' => $this->version])->lockForUpdate()->first()) {
                $newPage = $_newPage;
            } elseif ($previousPage && $previousPage->uses()->count() == 1) {
                $newPage = $previousPage;
                $newPage->update([
                    'states' => $states,
                    'states_hash' => $states_hash,
                    'version' => $this->version,
                ]);
            } else {
                $newPage = PageModel::create([
                    'reference' => $this->getStringReference(),
                    'states_hash' => $states_hash,
                    'states' => $states,
                    'version' => $this->version,
                ]);
            }

            $pageUse = $this->pageUseModel
                ? PageUseModel::query()
                    ->lockForUpdate()
                    ->find($this->pageUseModel->id)
                : null;

            if ($pageUse) {
                $pageUse->update([
                    'page_id' => $newPage->id,
                ]);
            } else {
                $pageUse = PageUseModel::create([
                    'page_id' => $newPage->id,
                    'chat_id' => event()->getChatId(),
                ]);
            }

            $pageUse->cells()->delete();
            foreach ($this->pageCells as $cell) {
                $cell->use_id = $pageUse->id;
                $cell->is_taking_control ??= false;
                PageCellModel::create($cell->getAttributes());
            }

            if ($previousPage && $previousPage->isNot($newPage)) {
                $this->deletePageIfNotUsed($previousPage);
            }
        });
    }

    protected function updateDatabaseStates(): void
    {
        $states = array_map(function (State $state) {
            return $state->value;
        }, $this->states);
        $states_hash = md5(json_encode($states));

        DB::connection(config('memogram.database.connection'))->transaction(function () use ($states, $states_hash) {
            $previousPage = $this->pageModel->exists
                ? PageModel::query()
                    ->where(['reference' => $this->pageModel->reference, 'states_hash' => $this->pageModel->states_hash])
                    ->lockForUpdate()
                    ->first()
                : null;

            if ($previousPage && $previousPage->states_hash == $states_hash) {
                return;
            } elseif ($_newPage = PageModel::query()->where(['reference' => $this->getStringReference(), 'states_hash' => $states_hash])->lockForUpdate()->first()) {
                $this->pageUseModel->update([
                    'page_id' => $_newPage->id,
                ]);
                return;
            } elseif ($previousPage && $previousPage->uses()->count() == 1) {
                $newPage = $previousPage;
                $newPage->update([
                    'states' => $states,
                    'states_hash' => $states_hash,
                ]);
            }

            if ($previousPage && $previousPage->isNot($newPage ?? null)) {
                $this->deletePageIfNotUsed($previousPage);
            }
        });
    }

    protected function deletePageUsage(PageModel $page, PageUseModel $use): void
    {
        DB::connection(config('memogram.database.connection'))->transaction(function () use ($page, $use) {
            $page = PageModel::query()
                ->lockForUpdate()
                ->where(['reference' => $page->reference, 'states_hash' => $page->states_hash])
                ->first();

            if (
                $page &&
                PageUseModel::query()->where('id', $use->id)->delete() &&
                !PageUseModel::query()->where('page_id', $page->id)->exists()
            ) {
                $page->delete();
            }
        });
    }

    protected function deletePageIfNotUsed(PageModel $page): void
    {
        DB::connection(config('memogram.database.connection'))->transaction(function () use ($page) {
            $page = PageModel::query()
                ->lockForUpdate()
                ->where(['reference' => $page->reference, 'states_hash' => $page->states_hash])
                ->first();

            if (
                $page &&
                !PageUseModel::query()->where('page_id', $page->id)->exists()
            ) {
                $page->delete();
            }
        });
    }

    protected function getStringReference(): string
    {
        if (is_array($this->reference)) {
            [$class, $method] = $this->reference;

            return (is_object($class) ? $class::class : $class) . '@' . $method;
        }

        return $this->reference;
    }

    protected function getReferenceCaller(): array
    {
        [$class, $method] = is_array($this->reference) ? $this->reference : explode('@', $this->reference);

        if (!is_object($class)) {
            $class = app($class);
        }

        return [$class, $method];
    }
}
