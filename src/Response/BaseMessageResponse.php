<?php

namespace MemoGram\Response;

use Illuminate\Support\Facades\Pipeline;
use MemoGram\Api\Types\KeyboardButton;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\ReplyKeyboardMarkup;
use MemoGram\Api\Types\ReplyParameters;
use MemoGram\Handle\Page;
use MemoGram\Matching\ListenerDispatcher;
use MemoGram\Models\PageCellModel;
use MemoGram\Support\MessageContent;
use function MemoGram\Handle\api;
use function MemoGram\Handle\event;

abstract class BaseMessageResponse extends BaseResponse
{
    protected ?string $message = null;
    protected ?MessageContent $content = null;
    protected array $args = [];
    protected ?array $schema = null;
    protected array $schemaUsing = [];
    protected bool $resetKeyboard = false;
    protected ?bool $save = null;
    protected ?bool $takeControl = null;

    public function message(?string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function content(?MessageContent $content)
    {
        $this->content = $content;
        return $this;
    }

    public function args(array $args)
    {
        $this->args = array_replace($this->args, $args);
        return $this;
    }

    public function schema(?array $schema)
    {
        $this->schema = $schema;
        return $this;
    }

    public function schemaUsing(Closure $callback)
    {
        $this->schemaUsing[] = $callback;
        return $this;
    }

    public function resetKeyboard()
    {
        $this->resetKeyboard = true;
        return $this;
    }

    public function save(?bool $value = true)
    {
        $this->save = $value;
        return $this;
    }

    public function takeControl(?bool $value = true)
    {
        $this->takeControl = $value;
        return $this;
    }


    public function runResponse(?Page $page, string $key): void
    {
        $chatId = event()?->getChatId();
        $messageId = event()?->getUserMessageId();

        $keyboardMarkup = $this->getFormattedKeyboardMarkup();

        $message = api()->sendMessage(
            chat_id: $chatId,
            text: value($this->message),
            reply_parameters: new ReplyParameters(
                message_id: $messageId,
                allow_sending_without_reply: true,
            ),
            reply_markup: $keyboardMarkup,
        );

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

    protected function getSchema(): array
    {
        return Pipeline::through($this->schemaUsing)
            ->send($this->schema ?? [])
            ->thenReturn();
    }

    protected function getContent(): MessageContent
    {
        return new MessageContent(
            $this->content?->type ?? Message::TYPE_TEXT,
            caption: $this->message ?? $this->content?->caption,
            content: $this->content?->content,
            entities: $this->content?->entities,
        );
    }

    /**
     * @return (Key|GlassKey)[][]
     */
    protected function getFormattedSchema(bool $onlyVisible): array
    {
        if (!$schema = $this->getSchema()) {
            return [];
        }

        $all = [];

        foreach ($schema as $row) {
            if (is_null($row) || $row === false) continue;

            $rowKey = [];

            /** @var null|false|Key|GlassKey $column */
            foreach ($row as $column) {
                if (is_null($column) || $column === false || !$column->interactable || ($onlyVisible && $column instanceof Key && !$column->visible)) continue;

                $rowKey[] = $column;
            }

            if ($rowKey) {
                $all[] = $rowKey;
            }
        }

        return $all;
    }
}