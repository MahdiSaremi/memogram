<?php

namespace MemoGram\Response;

use Closure;
use Illuminate\Support\Traits\Conditionable;

class Key
{
    use Conditionable;

    public mixed $then = null;
    public bool $atFirst = false;
    public bool $visible = true;
    public bool $interactable = true;

    public function __construct(
        public string $text,
    )
    {
    }

    public function then($callback)
    {
        $this->then = $callback;
        return $this;
    }

    public function atFirst(bool $value = true)
    {
        $this->atFirst = true;
        return $this;
    }

    public function visible(bool $value = true)
    {
        $this->visible = $value;
        return $this;
    }

    public function hidden(bool $value = true)
    {
        $this->visible = !$value;
        return $this;
    }

    public function if(bool $value = true)
    {
        $this->interactable = $value;
        return $this;
    }

    public function ifNot(bool $value = true)
    {
        $this->interactable = !$value;
        return $this;
    }
}