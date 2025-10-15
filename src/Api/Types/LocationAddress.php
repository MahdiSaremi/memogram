<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class LocationAddress
{
    use Concerns\Data;

    public function __construct(
        /** @var string The two-letter ISO 3166-1 alpha-2 country code of the country where the location is located */
        public string $country_code,
        
        /** @var string|null Optional. State of the location */
        public null|string $state = null,
        
        /** @var string|null Optional. City of the location */
        public null|string $city = null,
        
        /** @var string|null Optional. Street address of the location */
        public null|string $street = null,
        
        
    ) { }
}
