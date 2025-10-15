<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\StoryAreaPosition;
use MemoGram\Api\Types\StoryAreaType;


class StoryArea
{
    use Concerns\Data;

    public function __construct(
        /** @var StoryAreaPosition Position of the area */
        public StoryAreaPosition $position,
        
        /** @var StoryAreaType Type of the area */
        public StoryAreaType $type,
        
        
    ) { }
}
