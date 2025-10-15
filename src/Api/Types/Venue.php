<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Location;


class Venue
{
    use Concerns\Data;

    public function __construct(
        /** @var Location Venue location. Can't be a live location */
        public Location $location,
        
        /** @var string Name of the venue */
        public string $title,
        
        /** @var string Address of the venue */
        public string $address,
        
        /** @var string|null Optional. Foursquare identifier of the venue */
        public null|string $foursquare_id = null,
        
        /** @var string|null Optional. Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.) */
        public null|string $foursquare_type = null,
        
        /** @var string|null Optional. Google Places identifier of the venue */
        public null|string $google_place_id = null,
        
        /** @var string|null Optional. Google Places type of the venue. (See supported types.) */
        public null|string $google_place_type = null,
        
        
    ) { }
}
