<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Location;


class ChatLocation
{
    use Concerns\Data;

    public function __construct(
        /** @var Location The location to which the supergroup is connected. Can't be a live location. */
        public Location $location,
        
        /** @var string Location address; 1-64 characters, as defined by the chat owner */
        public string $address,
        
        
    ) { }
}
