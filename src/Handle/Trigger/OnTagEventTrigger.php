<?php

namespace MemoGram\Handle\Trigger;

use Closure;
use MemoGram\Handle\Event;
use MemoGram\Handle\Events\TagEvent;

class OnTagEventTrigger extends EventTrigger
{
    public function __construct(
        public string  $tag,
        public Closure $callback,
    )
    {
    }

    public function check(Event $event): bool
    {
        return $event instanceof TagEvent && $event->tag === $this->tag;
    }

    public function handle(Event $event): bool
    {
        
    }
}