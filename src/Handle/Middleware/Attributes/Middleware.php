<?php

namespace MemoGram\Handle\Middleware\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Middleware
{
    public function __construct(
        public mixed $middleware,
    )
    {
    }
}