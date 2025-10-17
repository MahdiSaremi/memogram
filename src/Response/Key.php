<?php

namespace MemoGram\Response;

use Closure;

class Key
{
    public ?Closure $then = null;

    public function __construct(
        public string $text,
    )
    {
    }

    public function then(Closure $callback)
    {
        $this->then = $callback;
        return $this;
    }
}