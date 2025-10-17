<?php

namespace MemoGram\Matching;

use MemoGram\Api\Types\CallbackQuery;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\Update;
use MemoGram\Handle\Event;

class MatcherHelper
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

    public function messageMatchType(Message $message, array $types, ?string &$out): bool
    {
        foreach ($types as $type) {
            if ($type == '*') {
                $out = isset($message->text) ? 'text' : '*';
                return true;
            }

            if (isset($message->{$type})) {
                $out = $type;
                return true;
            }
        }

        return false;
    }

    public function messageText(Message $message, string $type, false|string|null $expect): bool
    {
        if ($expect === false) {
            return true;
        }

        return ($type === 'text' ? $message->text : $message->caption) === $expect;
    }
}