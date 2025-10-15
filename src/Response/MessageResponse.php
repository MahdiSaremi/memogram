<?php

namespace MemoGram\Response;

use Illuminate\Support\Traits\Conditionable;
use MemoGram\Api\Types\ReplyParameters;
use MemoGram\Handle\Page;
use MemoGram\Models\PageCellModel;
use function MemoGram\Handle\context;
use function MemoGram\Handle\event;
use function MemoGram\Handle\page;

class MessageResponse implements AsResponse
{
    use Conditionable;

    public ?string $message = null;
    public ?array $schema = null;
    public bool $resetKeyboard = false;
    public ?string $id = null;
    public ?bool $save = null;

    public function message(?string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function schema(?array $schema)
    {
        $this->schema = $schema;
        return $this;
    }

    public function resetKeyboard()
    {
        $this->resetKeyboard = true;
        return $this;
    }

    public function id(?string $id)
    {
        $this->id = $id;
        return $this;
    }

    public function save(?bool $save = true)
    {
        $this->save = $save;
        return $this;
    }


    public function runResponse(Page $page, string $key): void
    {
        $chatId = event()?->getChatId();
        $messageId = event()?->getUserMessageId();

        $message = context()?->handler->api->sendMessage(
            chat_id: $chatId,
            text: value($this->message),
            reply_parameters: new ReplyParameters(
                message_id: $messageId,
                allow_sending_without_reply: true,
            ),
        );

        if ($this->save) {
            page()->pageCells->push(
                new PageCellModel([
                    'message_id' => $message->message_id,
                    'key' => $key,
                ]),
            );
        }
    }
}