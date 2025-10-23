<?php

namespace MemoGram\Response;

use Illuminate\Http\Client\RequestException;
use MemoGram\Api\Types\InlineKeyboardButton;
use MemoGram\Api\Types\InlineKeyboardMarkup;
use MemoGram\Api\Types\ReplyParameters;
use MemoGram\Handle\Page;
use MemoGram\Matching\ListenerDispatcher;
use MemoGram\Matching\Listeners\OnGlassKey;
use MemoGram\Models\PageCellModel;
use function MemoGram\Handle\api;
use function MemoGram\Handle\context;
use function MemoGram\Handle\event;

class GlassMessageResponse extends BaseResponse
{
    public ?string $message = null;
    public ?array $schema = null;
    protected bool $resend = false;
    protected bool $deleteOlder = true;

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

    public function resend(bool $deleteOlder = false)
    {
        $this->resend = true;
        $this->deleteOlder = $deleteOlder;
        return $this;
    }

    public function edit()
    {
        $this->resend = false;
        return $this;
    }


    public function runResponse(?Page $page, string $key): void
    {
        $this->runResponseOrRefresh($page, $key, null);
    }

    public function runRefresh(Page $page, string $key, ?PageCellModel $cell): void
    {
        $this->runResponseOrRefresh($page, $key, $cell);
    }

    protected function runResponseOrRefresh(?Page $page, string $key, ?PageCellModel $cell): void
    {
        $chatId = event()?->getChatId();
        $messageId = event()?->getUserMessageId();
        $shouldReply = !($page && $cell) || !$this->deleteOlder;

        [$hasCallback, $keyboardMarkup] = $this->getFormattedKeyboardMarkup();

        if ($page && $cell && !$this->resend) {
            try {
                api()->editMessageText(
                    text: value($this->message),
                    chat_id: $chatId,
                    message_id: $cell->message_id,
                    reply_markup: $keyboardMarkup,
                );
            } catch (RequestException $e) {
                if ($e->response->json('description') != 'Bad Request: message is not modified') {
                    throw $e;
                }
            }
        } else {
            $message = api()->sendMessage(
                chat_id: $chatId,
                text: value($this->message),
                reply_parameters: $shouldReply ? new ReplyParameters(
                    message_id: $messageId,
                    allow_sending_without_reply: true,
                ) : null,
                reply_markup: $keyboardMarkup,
            );

            if ($page && $cell && $this->deleteOlder) {
                try {
                    api()->deleteMessage(
                        chat_id: $chatId,
                        message_id: $cell->message_id,
                    );
                } catch (\Throwable $e) {}
            }
        }

        if ($hasCallback) {
            $page->pageCells->push(
                new PageCellModel([
                    'message_id' => $message?->message_id ?? $cell?->message_id,
                    'key' => $key,
                    'is_taking_control' => false,
                ]),
            );
        }
    }

    public function runListen(Page $page): void
    {
        $page->topListenUsing(function (ListenerDispatcher $match) {
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

    protected function getFormattedKeyboardMarkup(): array
    {
        $schema = $this->getFormattedSchema();

        if (!$schema) {
            return [false, null];
        }

        $hasCallback = false;
        $markup = new InlineKeyboardMarkup(
            inline_keyboard: array_map(function ($row) use (&$hasCallback) {
                return array_map(function (GlassKey $key) use (&$hasCallback) {
                    if (isset($key->url)) {
                        return new InlineKeyboardButton(
                            text: $key->text,
                            url: $key->url,
                        );
                    }

                    $hasCallback = true;

                    return new InlineKeyboardButton(
                        text: $key->text,
                        callback_data: OnGlassKey::getDataOf($key),
                    );
                }, $row);
            }, $schema),
        );

        return [$hasCallback, $markup];
    }
}