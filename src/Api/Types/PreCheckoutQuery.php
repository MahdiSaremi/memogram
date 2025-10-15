<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;
use MemoGram\Api\Types\OrderInfo;


class PreCheckoutQuery
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique query identifier */
        public string $id,
        
        /** @var User User who sent the query */
        public User $from,
        
        /** @var string Three-letter ISO 4217 currency code, or “XTR” for payments in Telegram Stars */
        public string $currency,
        
        /** @var int Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). */
        public int $total_amount,
        
        /** @var string Bot-specified invoice payload */
        public string $invoice_payload,
        
        /** @var string|null Optional. Identifier of the shipping option chosen by the user */
        public null|string $shipping_option_id = null,
        
        /** @var OrderInfo|null Optional. Order information provided by the user */
        public null|OrderInfo $order_info = null,
        
        
    ) { }
}
