<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\LocationAddress;


class StoryAreaTypeLocation
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the area, always “location” */
        public string $type,
        
        /** @var float Location latitude in degrees */
        public float $latitude,
        
        /** @var float Location longitude in degrees */
        public float $longitude,
        
        /** @var LocationAddress|null Optional. Address of the location */
        public null|LocationAddress $address = null,
        
        
    ) { }
}
