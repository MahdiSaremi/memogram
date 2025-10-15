<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\BackgroundType;


class ChatBackground
{
    use Concerns\Data;

    public function __construct(
        /** @var BackgroundType Type of the background */
        public BackgroundType $type,
        
        
    ) { }
}
