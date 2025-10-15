<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class StoryAreaTypeLink
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the area, always “link” */
        public string $type,
        
        /** @var string HTTP or tg:// URL to be opened when the area is clicked */
        public string $url,
        
        
    ) { }
}
