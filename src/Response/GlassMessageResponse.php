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
use MemoGram\Support\MessageContent;
use function MemoGram\Handle\api;
use function MemoGram\Handle\context;
use function MemoGram\Handle\event;

class GlassMessageResponse extends BaseMessageResponse
{
    protected bool $resend = false;
    protected bool $deleteOlder = true;

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
        $content = $this->getContent();
        $isEditable = MessageContent::isEditable($content->type);

        [$hasCallback, $keyboardMarkup] = $this->getFormattedKeyboardMarkup();

        $params = [
            'chat_id' => $chatId,
            'reply_markup' => $keyboardMarkup,
        ];

        if ($page && $cell && !$this->resend && $isEditable) {
            try {
                ($content->getEditApi())(array_replace(
                    $params,
                    ['message_id' => $messageId],
                    $content->getEditArgs(),
                    $this->args,
                ));
            } catch (RequestException $e) {
                if ($e->response->json('description') != 'Bad Request: message is not modified') {
                    throw $e;
                }
            }
        } else {
            $message = ($content->getApi())(array_replace(
                $params,
                [
                    'reply_parameters' => $shouldReply ? new ReplyParameters(
                        message_id: $messageId,
                        allow_sending_without_reply: true,
                    ) : null,
                ],
                $content->getArgs(),
                $this->args,
            ));

            if ($page && $cell && ($this->deleteOlder || !$isEditable)) {
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
            if ($schema = $this->getFormattedSchema(false)) {
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

    protected function getFormattedKeyboardMarkup(): array
    {
        $schema = $this->getFormattedSchema(true);

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