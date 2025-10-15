<?php

namespace MemoGram\Response;

use Illuminate\Support\Traits\Conditionable;
use MemoGram\Api\Types\KeyboardButton;
use MemoGram\Api\Types\ReplyKeyboardMarkup;
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

        $keyboardMarkup = $this->getFormattedKeyboardMarkup();

        $message = context()?->handler->api->sendMessage(
            chat_id: $chatId,
            text: value($this->message),
            reply_parameters: new ReplyParameters(
                message_id: $messageId,
                allow_sending_without_reply: true,
            ),
            reply_markup: $keyboardMarkup,
        );

        if ($this->save ?? $keyboardMarkup) {
            page()->pageCells->push(
                new PageCellModel([
                    'message_id' => $message->message_id,
                    'key' => $key,
                    'is_taking_control' => $keyboardMarkup !== null,
                ]),
            );
        }
    }

    /**
     * @return Key[][]
     */
    protected function getFormattedSchema(): array
    {
        if (!$this->schema) {
            return [];
        }

        $all = [];

        foreach ($this->schema as $row) {
            if (is_null($row) || $row === false) continue;

            $rowKey = [];

            foreach ($row as $column) {
                if (is_null($column) || $column === false) continue;

                $rowKey[] = $column;
            }

            if ($rowKey) {
                $all[] = $rowKey;
            }
        }

        return $all;
    }

    protected function getFormattedKeyboardMarkup(): ?ReplyKeyboardMarkup
    {
        $schema = $this->getFormattedSchema();

        if (!$schema) {
            return null;
        }

        return new ReplyKeyboardMarkup(
            keyboard: array_map(fn($row) => array_map(function (Key $key) {
                return new KeyboardButton(
                    text: $key->text,
                );
            }, $row), $schema),
            resize_keyboard: true,
        );
    }
}