<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\LocationAddress;


class StoryAreaTypeLocation extends StoryAreaType
{
    use Concerns\Data;

    /** @var string Type of the area, always “location” */
    public string $type = 'location';

    public function __construct(
        /** @var float Location latitude in degrees */
        public float $latitude,
        
        /** @var float Location longitude in degrees */
        public float $longitude,
        
        /** @var LocationAddress|null Optional. Address of the location */
        public null|LocationAddress $address = null,
        
        
    ) { }
}
