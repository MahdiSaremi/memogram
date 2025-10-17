<?php

namespace MemoGram\Response;

use MemoGram\Handle\Page;
use MemoGram\Models\PageCellModel;

class TakeControl extends BaseResponse
{
    public function runResponse(?Page $page, string $key): void
    {
        if ($page->pageCells->contains('is_taking_control', true)) {
            return;
        }

        if ($page->pageCells->isNotEmpty()) {
            $page->pageCells->first()->setAttribute('is_taking_control', true);
            return;
        }

        $page->pageCells->push(new PageCellModel([
            'key' => $key,
            'is_taking_control' => true,
        ]));
    }

    public function runListen(Page $page): void
    {
        // Nothing
    }

    public function runRefresh(Page $page, string $key, ?PageCellModel $cell): void
    {
        $this->runResponse($page, $key);
    }
}