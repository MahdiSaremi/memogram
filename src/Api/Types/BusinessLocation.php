<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Location;


class BusinessLocation
{
    use Concerns\Data;

    public function __construct(
        /** @var string Address of the business */
        public string $address,
        
        /** @var Location|null Optional. Location of the business */
        public null|Location $location = null,
        
        
    ) { }
}
