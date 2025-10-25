<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Api\Types\Message;
use MemoGram\Handle\Event;
use MemoGram\Matching\MatchHelper;
use MemoGram\Response\Key;
use function MemoGram\Handle\eventHandler;

class OnKey extends BaseListener
{
    public function __construct(
        public Key $key,
    )
    {
        $this->atFirst = $key->atFirst;
    }

    public function runCheck(Event $event, MatchHelper $match): bool
    {
        return $match->beMessage($event, $message)
            && $match->messageMatchType($message, [Message::TYPE_TEXT], $type)
            && $match->messageText($message, $this->key->text)
            && parent::runCheck($event, $match);
    }

    public function runAction(Event $event): void
    {
        if ($this->key->then) {
            eventHandler()->runAction(
                eventHandler()->createMiddlewarePipeline($this->middlewares, $this->key->then),
            );
        }

        parent::runAction($event);
    }
}