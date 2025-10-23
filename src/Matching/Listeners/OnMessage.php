<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Api\Types\Message;
use MemoGram\Handle\Event;
use MemoGram\Matching\MatchHelper;

class OnMessage extends BaseListener
{
    public ?array $types = null;
    public null|string|false $message = false;

    public function message(null|string|false $message)
    {
        if ($this->types === null) {
            $this->types = [Message::TYPE_TEXT];
        }

        $this->message = $message;
        return $this;
    }

    public function runCheck(Event $event, MatchHelper $match): bool
    {
        return $match->beMessage($event, $message)
            && $match->messageMatchType($message, $this->types, $type)
            && $match->messageText($message, $this->message)
            && parent::runCheck($event, $match);
    }
}