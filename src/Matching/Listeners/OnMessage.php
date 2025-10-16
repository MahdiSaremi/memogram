<?php

namespace MemoGram\Matching\Listeners;

use Closure;
use Illuminate\Support\Traits\Conditionable;
use MemoGram\Handle\Event;
use MemoGram\Matching\MatcherHelper;
use function MemoGram\Handle\context;

class OnMessage implements Listener
{
    use Conditionable;

    public array $types = ['*'];
    public null|string|false $message = false;
    public ?Closure $then = null;

    public function message(null|string|false $message)
    {
        if ($this->types == ['*']) {
            $this->types = ['text'];
        }

        $this->message = $message;
        return $this;
    }

    public function then(Closure $callback)
    {
        $this->then = $callback;
        return $this;
    }

    public function runCheck(Event $event, MatcherHelper $match): bool
    {
        return $match->beMessage($event, $message)
            && $match->messageMatchType($message, $this->types, $type)
            && $match->messageText($message, $type, $this->message);
    }

    public function runAction(Event $event): void
    {
        if ($this->then) {
            context()->handler->runAction($this->then);
        }
    }
}