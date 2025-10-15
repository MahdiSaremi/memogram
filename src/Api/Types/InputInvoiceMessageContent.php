<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class InputInvoiceMessageContent
{
    use Concerns\Data;

    public function __construct(
        /** @var string Product name, 1-32 characters */
        public string $title,
        
        /** @var string Product description, 1-255 characters */
        public string $description,
        
        /** @var string Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use it for your internal processes. */
        public string $payload,
        
        /** @var string|null Optional. Payment provider token, obtained via @BotFather. Pass an empty string for payments in Telegram Stars. */
        public null|string $provider_token = null,
        
        /** @var string Three-letter ISO 4217 currency code, see more on currencies. Pass “XTR” for payments in Telegram Stars. */
        public string $currency,
        
        /** @var array<\MemoGram\Api\Types\LabeledPrice> Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.). Must contain exactly one item for payments in Telegram Stars. */
        public array $prices,
        
        /** @var int|null Optional. The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double). For example, for a maximum tip of US$ 1.45 pass max_tip_amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). Defaults to 0. Not supported for payments in Telegram Stars. */
        public null|int $max_tip_amount = null,
        
        /** @var array<\MemoGram\Api\Types\int>|null Optional. A JSON-serialized array of suggested amounts of tip in the smallest units of the currency (integer, not float/double). At most 4 suggested tip amounts can be specified. The suggested tip amounts must be positive, passed in a strictly increased order and must not exceed max_tip_amount. */
        public null|array $suggested_tip_amounts = null,
        
        /** @var string|null Optional. A JSON-serialized object for data about the invoice, which will be shared with the payment provider. A detailed description of the required fields should be provided by the payment provider. */
        public null|string $provider_data = null,
        
        /** @var string|null Optional. URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service. */
        public null|string $photo_url = null,
        
        /** @var int|null Optional. Photo size in bytes */
        public null|int $photo_size = null,
        
        /** @var int|null Optional. Photo width */
        public null|int $photo_width = null,
        
        /** @var int|null Optional. Photo height */
        public null|int $photo_height = null,
        
        /** @var bool|null Optional. Pass True if you require the user's full name to complete the order. Ignored for payments in Telegram Stars. */
        public null|bool $need_name = null,
        
        /** @var bool|null Optional. Pass True if you require the user's phone number to complete the order. Ignored for payments in Telegram Stars. */
        public null|bool $need_phone_number = null,
        
        /** @var bool|null Optional. Pass True if you require the user's email address to complete the order. Ignored for payments in Telegram Stars. */
        public null|bool $need_email = null,
        
        /** @var bool|null Optional. Pass True if you require the user's shipping address to complete the order. Ignored for payments in Telegram Stars. */
        public null|bool $need_shipping_address = null,
        
        /** @var bool|null Optional. Pass True if the user's phone number should be sent to the provider. Ignored for payments in Telegram Stars. */
        public null|bool $send_phone_number_to_provider = null,
        
        /** @var bool|null Optional. Pass True if the user's email address should be sent to the provider. Ignored for payments in Telegram Stars. */
        public null|bool $send_email_to_provider = null,
        
        /** @var bool|null Optional. Pass True if the final price depends on the shipping method. Ignored for payments in Telegram Stars. */
        public null|bool $is_flexible = null,
        
        
    ) { }
}
