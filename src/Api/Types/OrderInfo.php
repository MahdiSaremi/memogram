<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\ShippingAddress;


class OrderInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var string|null Optional. User name */
        public null|string $name = null,
        
        /** @var string|null Optional. User's phone number */
        public null|string $phone_number = null,
        
        /** @var string|null Optional. User email */
        public null|string $email = null,
        
        /** @var ShippingAddress|null Optional. User shipping address */
        public null|ShippingAddress $shipping_address = null,
        
        
    ) { }
}
