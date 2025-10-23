<?php

namespace MemoGram\Response;

use Closure;

class Key
{
    public ?Closure $then = null;
    public bool $atFirst = false;

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

    public function atFirst(bool $value = true)
    {
        $this->atFirst = true;
        return $this;
    }
}