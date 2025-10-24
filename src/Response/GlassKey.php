<?php

namespace MemoGram\Response;
use Closure;
use Illuminate\Support\Traits\Conditionable;

class GlassKey
{
    use Conditionable;
    
    public ?Closure $then = null;
    public bool $interactable = true;

    public function __construct(
        public string $text,
        public ?string $id = null,
        public ?string $url = null,
    )
    {
    }

    public function url(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function then(Closure $callback)
    {
        $this->then = $callback;
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