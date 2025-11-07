<?php

namespace MemoGram\Handle\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Back
{
    public function __construct(
        public array $page,
    )
    {
    }
}