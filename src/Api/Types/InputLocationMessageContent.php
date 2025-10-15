<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputLocationMessageContent
{
    use Concerns\Data;

    public function __construct(
        /** @var float Latitude of the location in degrees */
        public float $latitude,
        
        /** @var float Longitude of the location in degrees */
        public float $longitude,
        
        /** @var float|null Optional. The radius of uncertainty for the location, measured in meters; 0-1500 */
        public null|float $horizontal_accuracy = null,
        
        /** @var int|null Optional. Period in seconds during which the location can be updated, should be between 60 and 86400, or 0x7FFFFFFF for live locations that can be edited indefinitely. */
        public null|int $live_period = null,
        
        /** @var int|null Optional. For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified. */
        public null|int $heading = null,
        
        /** @var int|null Optional. For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified. */
        public null|int $proximity_alert_radius = null,
        
        
    ) { }
}
