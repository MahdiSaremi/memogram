<?php

namespace MemoGram\Response;

use MemoGram\Handle\Page;
use MemoGram\Models\PageCellModel;

interface AsResponse
{
    public function runResponse(?Page $page, string $key): void;

    public function runListen(Page $page): void;

    public function runRefresh(Page $page, string $key, ?PageCellModel $cell): void;

//    public function runRevoke(PageModel $model, PageCellModel $cell): bool;
}