<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Handle\Event;
use MemoGram\Matching\MatcherHelper;
use MemoGram\Response\Key;
use function MemoGram\Handle\context;

class OnKey extends BaseListener
{
    public function __construct(
        public Key $key,
    )
    {
    }

    public function runCheck(Event $event, MatcherHelper $match): bool
    {
        return $match->beMessage($event, $message)
            && $match->messageMatchType($message, ['text'], $type)
            && $match->messageText($message, $type, $this->key->text);
    }

    public function runAction(Event $event): void
    {
        if ($this->key->then) {
            context()->handler->runAction($this->key->then);
        }

        parent::runAction($event);
    }
}