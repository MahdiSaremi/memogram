<?php

namespace MemoGram\Handle;

class ActionCallback
{
    public function __construct(
        protected $callback,
    )
    {
    }

    public function __invoke(...$args)
    {
        context()->handler->runAction($this->callback, $args);
    }
}