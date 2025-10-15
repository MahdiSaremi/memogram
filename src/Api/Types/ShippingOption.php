<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ShippingOption
{
    use Concerns\Data;

    public function __construct(
        /** @var string Shipping option identifier */
        public string $id,
        
        /** @var string Option title */
        public string $title,
        
        /** @var array<\MemoGram\Api\Types\LabeledPrice> List of price portions */
        public array $prices,
        
        
    ) { }
}
