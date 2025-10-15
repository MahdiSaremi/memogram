<?php

namespace MemoGram\Handle;

use Illuminate\Database\Eloquent\Collection;
use MemoGram\Models\PageCellModel;
use MemoGram\Models\PageModel;
use MemoGram\Response\AsResponse;

class Page
{
    public array $params = [];
    public int $status = 0;
    public array $states = [];
    public int $statePointer = 0;
    public PageModel $pageModel;
    /** @var Collection<int,PageCellModel> */
    public Collection $pageCells;

    public const STATUS_NOTING = 0;
    public const STATUS_MOUNTING = 1;
    public const STATUS_HYDRATING = 2;

    public function __construct(
        public string $reference,
    )
    {
    }

    public function mount(array $params): void
    {
        $this->status = self::STATUS_MOUNTING;
        $this->params = array_replace($this->params, $params);
        $this->pageModel = new PageModel();
        $this->pageCells = new Collection();

        $this->callReference();


    }

    public function hydrate(): void
    {
        $this->status = self::STATUS_HYDRATING;
        $this->statePointer = 0;
        $this->callReference();
    }

    public function useState($defaultValue)
    {
        switch ($this->status) {
            case self::STATUS_MOUNTING:
                $state = new State($defaultValue);
                $this->states[] = $state;
                return $state;

            case self::STATUS_HYDRATING:
                if ($this->statePointer < count($this->states)) {
                    return $this->states[$this->statePointer];
                } else {
                    throw new \Exception("State is not exists.");
                }

            default:
                throw new \Exception("Invalid state.");
        }
    }

    protected function callReference(): void
    {
        [$class, $method] = explode('@', $this->reference);

        context()->handler->pageStack[] = $this;

        try {
            context()->handler->handleResponse(
                app($class)->$method(),
            );
        } finally {
            array_pop(context()->handler->pageStack);
        }
    }
}