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

        $this->requireRefresh = false;
        $this->callReference(function ($response) {
            /**
             * @var string $key
             * @var AsResponse $response
             */
            foreach (context()->handler->normalizeResponse($response) as [$key, $response]) {
                $response->runListen($this);
            }
        });

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
        }
    }

    public function pushEvent(Event $event): void
    {

    }

    public function listenUsing(Closure $callback): void
    {
        $callback($this->listener);
    }

    public function useState($defaultValue): State
    {
        switch ($this->status) {
            case self::STATUS_MOUNTING:
                $state = new State($defaultValue);
                $this->states[] = $state;
                return $state;

            case self::STATUS_HYDRATING:
                if ($this->statePointer < count($this->hydratedStates)) {
                    return $this->states[$this->statePointer] = new State($this->hydratedStates[$this->statePointer++]);
                } else {
                    return $this->states[$this->statePointer++] = new State($defaultValue);
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
            $previousPage = null;

            if ($isSame = $this->pageModel->exists && $this->pageModel->states_hash == $states_hash) {
                if (!$page = PageModel::query()
                    ->lockForUpdate()
                    ->where(['reference' => $this->reference, 'states_hash' => $states_hash])
                    ->first()) {
                    $isSame = false;

                    $page = PageModel::create([
                        'reference' => $this->reference,
                        'states_hash' => $states_hash,
                        'states' => $states,
                    ]);
                }
            } else {
                $previousPage = $this->pageModel->exists ? PageModel::query()
                    ->lockForUpdate()
                    ->where(['reference' => $this->pageModel->reference, 'states_hash' => $this->pageModel->states_hash])
                    ->first() : null;

                if ($previousPage && PageUseModel::query()->where('page_id', $previousPage->id)->count() == 1) {
                    $page = $previousPage;
                    $previousPage = null;
                    $isSame = true;
                } else {
                    $page = PageModel::query()
                        ->lockForUpdate()
                        ->firstOrCreate(['reference' => $this->reference, 'states_hash' => $states_hash], ['states' => $states]);
                }
            }

            /** @var PageUseModel $use */
            if ($this->pageUseModel && PageUseModel::query()->where('id', $this->pageUseModel->id)->update(['page_id' => $page->id])) {
                $use = PageUseModel::find($this->pageUseModel->id);
            } else {
                $use = PageUseModel::create([
                    'page_id' => $page->id,
                    'chat_id' => event()->getChatId(),
                ]);
            }

            foreach ($this->pageCells as $cell) {
                $cell->use_id = $use->id;
                $cell->is_taking_control ??= false;
                if ($use->wasRecentlyCreated) {
                    $cell = PageCellModel::create($cell->getAttributes());
                } else {
                    $cell->save();
                }
            }

            if ($previousPage) {
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