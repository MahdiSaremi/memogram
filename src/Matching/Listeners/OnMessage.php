<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Handle\Event;
use MemoGram\Matching\MatcherHelper;

class OnMessage extends BaseListener
{
    public array $types = ['*'];
    public null|string|false $message = false;

    public function message(null|string|false $message)
    {
        if ($this->types == ['*']) {
            $this->types = ['text'];
        }

        $this->message = $message;
        return $this;
    }

    public function runCheck(Event $event, MatcherHelper $match): bool
    {
        return $match->beMessage($event, $message)
            && $match->messageMatchType($message, $this->types, $type)
            && $match->messageText($message, $type, $this->message);
    }
}