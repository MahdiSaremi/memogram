<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Invoice
{
    use Concerns\Data;

    public function __construct(
        /** @var string Product name */
        public string $title,
        
        /** @var string Product description */
        public string $description,
        
        /** @var string Unique bot deep-linking parameter that can be used to generate this invoice */
        public string $start_parameter,
        
        /** @var string Three-letter ISO 4217 currency code, or “XTR” for payments in Telegram Stars */
        public string $currency,
        
        /** @var int Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). */
        public int $total_amount,
        
        
    ) { }
}
