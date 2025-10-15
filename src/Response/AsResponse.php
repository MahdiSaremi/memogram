<?php

namespace MemoGram\Response;

use MemoGram\Models\PageCellModel;
use MemoGram\Models\PageModel;

interface AsResponse
{
    public function runResponse(PageModel $model): ?PageCellModel;

    public function runMorph(PageModel $model, PageCellModel $cell): ?PageCellModel;

    public function runRevoke(PageModel $model, PageCellModel $cell): bool;
}