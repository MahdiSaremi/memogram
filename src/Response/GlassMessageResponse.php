<?php

namespace MemoGram\Response;

use MemoGram\Api\Types\InlineKeyboardButton;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\KeyboardButton;
use MemoGram\Api\Types\ReplyKeyboardMarkup;
use MemoGram\Api\Types\ReplyParameters;
use MemoGram\Handle\Page;
use MemoGram\Matching\ListenerMatcher;
use MemoGram\Models\PageCellModel;
use function MemoGram\Handle\context;
use function MemoGram\Handle\event;

class GlassMessageResponse extends BaseResponse
{
    public ?string $message = null;
    public ?array $schema = null;

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


    public function runResponse(?Page $page, string $key): void
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

        if ($keyboardMarkup) {
            $page->pageCells->push(
                new PageCellModel([
                    'message_id' => $message->message_id,
                    'key' => $key,
                    'is_taking_control' => false,
                ]),
            );
        }
    }

    public function runRefresh(Page $page, string $key, ?PageCellModel $cell): void
    {
        $this->runResponse($page, $key);
    }

    public function runListen(Page $page): void
    {
        $page->topListenUsing(function (ListenerMatcher $match) {
            if ($schema = $this->getFormattedSchema()) {
                foreach ($schema as $row) {
                    foreach ($row as $key) {
                        if ($key->then && !isset($key->url)) {
                            $match->onGlassKey($key);
                        }
                    }
                }
            }
        });
    }

    /**
     * @return GlassKey[][]
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

    protected function getFormattedKeyboardMarkup(): ?InlineKeyboardMarkup
    {
        $schema = $this->getFormattedSchema();

        if (!$schema) {
            return null;
        }

        return new InlineKeyboardMarkup(
            inline_keyboard: array_map(fn($row) => array_map(function (GlassKey $key) {
                if (isset($key->url)) {
                    return new InlineKeyboardButton(
                        text: $key->text,
                        url: $key->url,
                    );
                }

                return new InlineKeyboardButton(
                    text: $key->text,
                    callback_data: $key->id,
                );
            }, $row), $schema),
        );
    }
}