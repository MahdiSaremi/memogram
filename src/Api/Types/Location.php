<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Location
{
    use Concerns\Data;

    public function __construct(
        /** @var float Latitude as defined by the sender */
        public float $latitude,
        
        /** @var float Longitude as defined by the sender */
        public float $longitude,
        
        /** @var float|null Optional. The radius of uncertainty for the location, measured in meters; 0-1500 */
        public null|float $horizontal_accuracy = null,
        
        /** @var int|null Optional. Time relative to the message sending date, during which the location can be updated; in seconds. For active live locations only. */
        public null|int $live_period = null,
        
        /** @var int|null Optional. The direction in which user is moving, in degrees; 1-360. For active live locations only. */
        public null|int $heading = null,
        
        /** @var int|null Optional. The maximum distance for proximity alerts about approaching another chat member, in meters. For sent live locations only. */
        public null|int $proximity_alert_radius = null,
        
        
    ) { }
}
