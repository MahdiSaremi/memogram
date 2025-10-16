<?php

namespace MemoGram\Response;

use MemoGram\Handle\Page;

interface AsResponse
{
    public function runResponse(?Page $page, string $key): void;

//    public function runMorph(Page $page, PageCellModel $cell): ?PageCellModel;
//
//    public function runRevoke(PageModel $model, PageCellModel $cell): bool;
}