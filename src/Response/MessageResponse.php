<?php

namespace MemoGram\Response;

use Closure;
use Illuminate\Support\Facades\Pipeline;
use MemoGram\Api\Types\KeyboardButton;
use MemoGram\Api\Types\ReplyKeyboardMarkup;
use MemoGram\Api\Types\ReplyParameters;
use MemoGram\Handle\Page;
use MemoGram\Matching\ListenerDispatcher;
use MemoGram\Models\PageCellModel;
use function MemoGram\Handle\api;
use function MemoGram\Handle\event;

class MessageResponse extends BaseMessageResponse
{
    public function runResponse(?Page $page, string $key): void
    {
        $chatId = event()?->getChatId();
        $messageId = event()?->getUserMessageId();

        $keyboardMarkup = $this->getFormattedKeyboardMarkup();
        $content = $this->getContent();

        $message = ($content->getApi())(...array_replace(
            [
                'chat_id' => $chatId,
                'reply_parameters' => new ReplyParameters(
                    message_id: $messageId,
                    allow_sending_without_reply: true,
                ),
                'reply_markup' => $keyboardMarkup,
            ],
            $content->getArgs(),
            $this->args,
        ));

        foreach ($this->afterMessageRespond as $callback) {
            $callback($message);
        }

        if ($this->save ?? ($this->takeControl || $keyboardMarkup)) {
            $page->pageCells->push(
                new PageCellModel([
                    'message_id' => $message->message_id,
                    'key' => $key,
                    'is_taking_control' => $this->takeControl ?? ($keyboardMarkup !== null),
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
        $page->topListenUsing(function (ListenerDispatcher $match) {
            if ($schema = $this->getFormattedSchema(false)) {
                foreach ($schema as $row) {
                    foreach ($row as $key) {
                        if ($key->then) {
                            $match->onKey($key);
                        }
                    }
                }
            }
        });
    }

    protected function getFormattedKeyboardMarkup(): ?ReplyKeyboardMarkup
    {
        $schema = $this->getFormattedSchema(true);

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