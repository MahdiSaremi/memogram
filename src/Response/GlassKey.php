<?php

namespace MemoGram\Response;
use Closure;

class GlassKey
{
    public ?Closure $then = null;

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
}