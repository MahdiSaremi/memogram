<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;
use MemoGram\Api\Types\ShippingAddress;


class ShippingQuery
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique query identifier */
        public string $id,
        
        /** @var User User who sent the query */
        public User $from,
        
        /** @var string Bot-specified invoice payload */
        public string $invoice_payload,
        
        /** @var ShippingAddress User specified shipping address */
        public ShippingAddress $shipping_address,
        
        
    ) { }
}
