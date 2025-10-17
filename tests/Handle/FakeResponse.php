<?php

namespace MemoGram\Tests\Handle;

use MemoGram\Handle\Page;
use MemoGram\Models\PageCellModel;
use MemoGram\Response\AsResponse;

class FakeResponse implements AsResponse
{
    public bool $respond = false;
    public bool $listened = false;
    public bool $refreshed = false;

    public function __construct(
        public mixed $value,
        public bool $takeControl = true,
    )
    {
    }

    public function runResponse(?Page $page, string $key): void
    {
        $this->respond = true;
        $page?->pageCells->push(new PageCellModel([
            'key' => $key,
            'is_taking_control' => $this->takeControl,
            'message_id' => is_numeric($key) ? +$key : null,
        ]));
    }

    public function runListen(Page $page): void
    {
        $this->listened = true;
    }

    public function runRefresh(Page $page, string $key, ?PageCellModel $cell): void
    {
        $this->refreshed = true;
        $this->runResponse($page, $key);
    }
}