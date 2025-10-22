<?php

namespace MemoGram\Response;

use MemoGram\Handle\Page;
use MemoGram\Models\PageCellModel;

class DeleteResponse extends BaseResponse
{
    public function runResponse(?Page $page, string $key): void
    {
    }

    public function runListen(Page $page): void
    {
    }

    public function runRefresh(Page $page, string $key, ?PageCellModel $cell): void
    {
        if ($cell && $cell->message_id) {
            try {
                \MemoGram\Handle\context()->handler->api->deleteMessage(
                    chat_id: $cell->use->chat_id,
                    message_id: $cell->message_id,
                );
            } catch (\Throwable) {}
        }
    }
}