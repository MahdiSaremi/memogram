<?php

namespace MemoGram\Matching;

use MemoGram\Api\Types\CallbackQuery;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\Update;
use MemoGram\Handle\Event;

class MatchHelper
{
    public function beMessage(Event $event, ?Message &$out): bool
    {
        if ($event instanceof Update && $event->message) {
            $out = $event->message;
            return true;
        }

        return false;
    }

    public function beCallbackQuery(Event $event, ?CallbackQuery &$out): bool
    {
        if ($event instanceof Update && $event->callback_query) {
            $out = $event->callback_query;
            return true;
        }

        return false;
    }

    public function messageMatchType(Message $message, ?array $types, ?string &$out): bool
    {
        $actualType = $message->getType();

        if ($types === null || in_array($actualType, $types, true)) {
            $out = $actualType;
            return true;
        }

        return false;
    }

    public function messageText(Message $message, false|string|null $expect): bool
    {
        if ($expect === false) {
            return true;
        }

        return ($message->caption ?? $message->text) === $expect;
    }
}