<?php

namespace MemoGram\Matching\Listeners;

use Closure;
use MemoGram\Handle\Event;
use MemoGram\Matching\MatchHelper;

class OnAny extends BaseListener
{
    public function __construct(
        Closure $callback,
    )
    {
        $this->then($callback);
    }
}