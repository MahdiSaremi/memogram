<?php

namespace MemoGram\Handle;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use MemoGram\Matching\ListenerMatcher;
use MemoGram\Models\PageCellModel;
use MemoGram\Models\PageModel;
use MemoGram\Models\PageUseModel;
use MemoGram\Response\AsResponse;

class Page
{
    public array $params = [];
    public int $status = 0;
    protected array $hydratedStates;
    protected array $states = [];
    protected int $statePointer = 0;
    public PageModel $pageModel;
    public ?PageUseModel $pageUseModel = null;
    /** @var Collection<int,PageCellModel> */
    public Collection $pageCells;
    public ListenerMatcher $listener;
    protected bool $requireRefresh = false;
    protected bool $requireSave = false;

    public const STATUS_NOTING = 0;
    public const STATUS_MOUNTING = 1;
    public const STATUS_HYDRATING = 2;
    public const STATUS_REFRESHING = 3;

    public function __construct(
        public string $reference,
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

    public function mount(array $params): void
    {
        $this->status = self::STATUS_MOUNTING;
        $this->params = array_replace($this->params, $params);
        $this->pageModel = new PageModel();
        $this->pageCells = new Collection();
        $this->listener = new ListenerMatcher();

        $this->callReference(function ($response) {
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
        $this->status = self::STATUS_HYDRATING;
        $this->statePointer = 0;
        $this->pageModel = $use->page;
        $this->pageUseModel = $use;
        $this->pageCells = $this->pageUseModel->cells()->get();
        $this->hydratedStates = $use->page->states;
        $this->listener = new ListenerMatcher();

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

    public function pushHydratedEvent(Event $event, Closure $callback): void
    {
        $this->requireRefresh = false;
        $this->pushHydratedEventWithoutRefreshing($event, $callback);

        if ($this->requireRefresh) {
            $this->status = self::STATUS_REFRESHING;
            $this->statePointer = 0;
            $this->listener = new ListenerMatcher();
            $cells = $this->pageCells;
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
    }

    protected function pushHydratedEventWithoutRefreshing(Event $event, Closure $callback): void
    {
        try {
            context()->handler->pageStack[] = $this;
            if ($this->listener->pushEventAt($event, true)) {
                return;
            }
        } finally {
            array_pop(context()->handler->pageStack);
        }

        if ($callback()) {
            return;
        }

        try {
            context()->handler->pageStack[] = $this;
            if ($this->listener->pushEventAt($event, false)) {
                return;
            }
        } finally {
            array_pop(context()->handler->pageStack);
        }
    }

    public function listenUsing(Closure $callback): void
    {
        $callback($this->listener);
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

    protected function callReference(Closure $callback): void
    {
        [$class, $method] = explode('@', $this->reference);

        context()->handler->pageStack[] = $this;

        try {
            $callback(
                app($class)->$method(),
            );
        } finally {
            array_pop(context()->handler->pageStack);
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
                    ->where(['reference' => $this->pageModel->reference, 'states_hash' => $this->pageModel->states_hash])
                    ->lockForUpdate()
                    ->first()
                : null;

            if ($previousPage && $previousPage->states_hash == $states_hash) {
                $newPage = $previousPage;
            } elseif ($_newPage = PageModel::query()->where(['reference' => $this->reference, 'states_hash' => $states_hash])->lockForUpdate()->first()) {
                $newPage = $_newPage;
            } elseif ($previousPage && $previousPage->uses()->count() == 1) {
                $newPage = $previousPage;
                $newPage->update([
                    'states' => $states,
                    'states_hash' => $states_hash,
                ]);
            } else {
                $newPage = PageModel::create([
                    'reference' => $this->reference,
                    'states_hash' => $states_hash,
                    'states' => $states,
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
            } elseif ($_newPage = PageModel::query()->where(['reference' => $this->reference, 'states_hash' => $states_hash])->lockForUpdate()->first()) {
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
}
