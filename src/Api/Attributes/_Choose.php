<?php

namespace MemoGram\Api\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class _Choose
{
    public function __construct(
        public string $key,
        public array  $using,
    )
    {
    }
}