<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\OrderInfo;


class SuccessfulPayment
{
    use Concerns\Data;

    public function __construct(
        /** @var string Three-letter ISO 4217 currency code, or “XTR” for payments in Telegram Stars */
        public string $currency,
        
        /** @var int Total price in the smallest units of the currency (integer, not float/double). For example, for a price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). */
        public int $total_amount,
        
        /** @var string Bot-specified invoice payload */
        public string $invoice_payload,
        
        /** @var int|null Optional. Expiration date of the subscription, in Unix time; for recurring payments only */
        public null|int $subscription_expiration_date = null,
        
        /** @var bool|null Optional. True, if the payment is a recurring payment for a subscription */
        public null|bool $is_recurring = null,
        
        /** @var bool|null Optional. True, if the payment is the first payment for a subscription */
        public null|bool $is_first_recurring = null,
        
        /** @var string|null Optional. Identifier of the shipping option chosen by the user */
        public null|string $shipping_option_id = null,
        
        /** @var OrderInfo|null Optional. Order information provided by the user */
        public null|OrderInfo $order_info = null,
        
        /** @var string Telegram payment identifier */
        public string $telegram_payment_charge_id,
        
        /** @var string Provider payment identifier */
        public string $provider_payment_charge_id,
        
        
    ) { }
}
