<?php

namespace MemoGram\Matching\Listeners;

use Closure;
use MemoGram\Handle\Event;
use MemoGram\Matching\MatcherHelper;

class OnAny extends BaseListener
{
    public function __construct(
        Closure $callback,
    )
    {
        $this->then($callback);
    }

    public function runCheck(Event $event, MatcherHelper $match): bool
    {
        return true;
    }
}