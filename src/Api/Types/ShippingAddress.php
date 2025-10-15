<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ShippingAddress
{
    use Concerns\Data;

    public function __construct(
        /** @var string Two-letter ISO 3166-1 alpha-2 country code */
        public string $country_code,
        
        /** @var string State, if applicable */
        public string $state,
        
        /** @var string City */
        public string $city,
        
        /** @var string First line for the address */
        public string $street_line1,
        
        /** @var string Second line for the address */
        public string $street_line2,
        
        /** @var string Address post code */
        public string $post_code,
        
        
    ) { }
}
