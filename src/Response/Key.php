<?php

namespace MemoGram\Response;

use Closure;

class Key
{
    public ?Closure $action = null;

    public function __construct(
        public string $text,
    )
    {
    }

    public function action(Closure $callback)
    {
        $this->action = $callback;
        return $this;
    }
}