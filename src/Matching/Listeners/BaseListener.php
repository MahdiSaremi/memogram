<?php

namespace MemoGram\Matching\Listeners;

use Closure;
use Illuminate\Support\Traits\Conditionable;
use MemoGram\Handle\Event;
use function MemoGram\Handle\context;

abstract class BaseListener implements Listener
{
    use Conditionable;

    public bool $atFirst = false;
    public ?Closure $then = null;

    public function atFirst()
    {
        $this->atFirst = true;
        return $this;
    }

    public function atLast()
    {
        $this->atFirst = false;
        return $this;
    }

    public function then(Closure $callback)
    {
        $this->then = $callback;
        return $this;
    }

    public function runAction(Event $event): void
    {
        if ($this->then) {
            context()->handler->runAction($this->then);
        }
    }
}