<?php

namespace MemoGram\Handle;

class Context
{
    public function __construct(
        public EventHandler $handler,
        public Event        $event,
    )
    {
    }
}