<?php

namespace MemoGram\Support;

use Closure;
use Illuminate\Support\Str;
use MemoGram\Api\TelegramApi;
use MemoGram\Api\Types\InputMedia;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\MessageEntity;
use function MemoGram\Handle\api;

readonly class MessageContent
{
    public const SUPPORTED_TYPES = [
        Message::TYPE_TEXT,
        Message::TYPE_PHOTO,
        Message::TYPE_VIDEO,
        Message::TYPE_DOCUMENT,
        Message::TYPE_AUDIO,
        Message::TYPE_VOICE,
        Message::TYPE_ANIMATION,
        Message::TYPE_VIDEO_NOTE,
        Message::TYPE_STICKER,
        Message::TYPE_LOCATION,
    ];

    public function __construct(
        public string  $type,
        public ?string $caption,
        public mixed   $content = null,
        /** @var null|MessageEntity[] $entities */
        public ?array  $entities = null,
    )
    {
    }

    public static function isAble(string $type): bool
    {
        return in_array($type, self::SUPPORTED_TYPES, true);
    }

    public static function isEditable(string $type): bool
    {
        return in_array($type, [
            Message::TYPE_TEXT,
            Message::TYPE_PHOTO,
            Message::TYPE_VIDEO,
            Message::TYPE_DOCUMENT,
            Message::TYPE_AUDIO,
            Message::TYPE_VOICE,
            Message::TYPE_ANIMATION,
            Message::TYPE_VIDEO_NOTE,
        ], true);
    }

    public static function fromMessage(Message $message, bool $includeEntities = true): static
    {
        $type = $message->getType();
        if (!in_array($type, self::SUPPORTED_TYPES, true)) {
            throw new \InvalidArgumentException("Message type [$type] is not supported as a resenable message.");
        }

        $caption = $message->caption ?? $message->text;
        $entities = $includeEntities ? $message->caption_entities ?? $message->entities : null;
        $content = match ($type) {
            Message::TYPE_TEXT => null,
            Message::TYPE_PHOTO => collect($message->photo)->last()->file_id ?? null,
            Message::TYPE_LOCATION => $message->location->latitude . ',' . $message->location->longitude,
            default => $message->{$type}?->file_id ?? null,
        };

        return new static(
            type: $type,
            caption: $caption,
            content: $content,
            entities: $entities,
        );
    }

    protected static function applyEntitiesToHtml(string $text, array $entities): string
    {
        $utf16 = mb_convert_encoding($text, 'UTF-16', 'UTF-8');
        $chars = preg_split('//u', $utf16, -1, PREG_SPLIT_NO_EMPTY);

        usort($entities, fn($a, $b) => ($b->offset ?? 0) <=> ($a->offset ?? 0));

        /** @var MessageEntity $entity */
        foreach ($entities as $entity) {
            $offset = $entity->offset ?? 0;
            $length = $entity->length ?? 0;

            $part = implode('', array_slice($chars, $offset, $length));
            $partUtf8 = htmlentities(mb_convert_encoding($part, 'UTF-8', 'UTF-16'));

            $tagged = match ($entity->type) {
                'bold' => "<b>{$partUtf8}</b>",
                'italic' => "<i>{$partUtf8}</i>",
                'underline' => "<u>{$partUtf8}</u>",
                'strikethrough' => "<s>{$partUtf8}</s>",
                'code' => "<code>{$partUtf8}</code>",
                'pre' => "<pre>{$partUtf8}</pre>",
                'text_link' => "<a href=\"{$entity->url}\">{$partUtf8}</a>",
                'text_mention' => "<a href=\"tg://user?id={$entity->user->id}\">{$partUtf8}</a>",
                default => $partUtf8,
            };

            array_splice($chars, $offset, $length, [mb_convert_encoding($tagged, 'UTF-16', 'UTF-8')]);
        }

        return mb_convert_encoding(implode('', $chars), 'UTF-8', 'UTF-16');
    }

    public function getApi(?TelegramApi $api = null): Closure
    {
        $api ??= api();

        return match ($this->type) {
            Message::TYPE_TEXT => $api->sendMessage(...),
            Message::TYPE_LOCATION => $api->sendLocation(...),
            default => $api->{
                'send' . Str::pascal($this->type)
            }(...),
        };
    }

    public function getArgs(): array
    {
        return match ($this->type) {
            Message::TYPE_TEXT => [
                'text' => $this->caption,
                'entities' => $this->entities,
            ],
            Message::TYPE_LOCATION => [
                'latitude' => Str::before($this->content, ','),
                'longitude' => Str::after($this->content, ','),
            ],
            default => [
                'caption' => $this->caption,
                'caption_entities' => $this->entities,
                $this->type => $this->content,
            ],
        };
    }

    public function getEditApi(?TelegramApi $api = null): Closure
    {
        if (!self::isEditable($this->type)) {
            throw new \LogicException("Message type [{$this->type}] is not editable.");
        }

        $api ??= api();

        return match ($this->type) {
            Message::TYPE_TEXT => $api->editMessageText(...),
            default => $api->editMessageMedia(...),
        };
    }

    public function getEditArgs(): array
    {
        if (!self::isEditable($this->type)) {
            throw new \LogicException("Message type [{$this->type}] is not editable.");
        }

        return match ($this->type) {
            Message::TYPE_TEXT => [
                'text' => $this->caption,
                'entities' => $this->entities,
            ],
            default => [
                'media' => [
                    'type' => $this->type,
                    'media' => $this->content,
                ],
                'caption' => $this->caption,
                'caption_entities' => $this->entities,
            ],
        };
    }

    public function send(TelegramApi $api, string|int $chat_id, ...$args): mixed
    {
        return $this->getApi($api)(...[...$this->getArgs(), 'chat_id' => $chat_id, ...$args]);
    }

    public function edit(TelegramApi $api, string|int $chat_id, string|int $message_id, ...$args): mixed
    {
        return $this->getEditApi($api)(...[...$this->getEditArgs(), 'chat_id' => $chat_id, 'message_id' => $message_id, ...$args]);
    }
}