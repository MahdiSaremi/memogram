<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class StoryAreaTypeUniqueGift extends StoryAreaType
{
    use Concerns\Data;

    /** @var string Type of the area, always “unique_gift” */
    public string $type = 'unique_gift';

    public function __construct(
        /** @var string Unique name of the gift */
        public string $name,
        
        
    ) { }
}
