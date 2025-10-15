<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;
use MemoGram\Api\Types\AffiliateInfo;
use MemoGram\Api\Types\Gift;


class TransactionPartner
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the transaction partner, always “user” */
        public string $type,
        
        /** @var string Type of the transaction, currently one of “invoice_payment” for payments via invoices, “paid_media_payment” for payments for paid media, “gift_purchase” for gifts sent by the bot, “premium_purchase” for Telegram Premium subscriptions gifted by the bot, “business_account_transfer” for direct transfers from managed business accounts */
        public string $transaction_type,
        
        /** @var User Information about the user */
        public User $user,
        
        /** @var AffiliateInfo|null Optional. Information about the affiliate that received a commission via this transaction. Can be available only for “invoice_payment” and “paid_media_payment” transactions. */
        public null|AffiliateInfo $affiliate = null,
        
        /** @var string|null Optional. Bot-specified invoice payload. Can be available only for “invoice_payment” transactions. */
        public null|string $invoice_payload = null,
        
        /** @var int|null Optional. The duration of the paid subscription. Can be available only for “invoice_payment” transactions. */
        public null|int $subscription_period = null,
        
        /** @var array<\MemoGram\Api\Types\PaidMedia>|null Optional. Information about the paid media bought by the user; for “paid_media_payment” transactions only */
        public null|array $paid_media = null,
        
        /** @var string|null Optional. Bot-specified paid media payload. Can be available only for “paid_media_payment” transactions. */
        public null|string $paid_media_payload = null,
        
        /** @var Gift|null Optional. The gift sent to the user by the bot; for “gift_purchase” transactions only */
        public null|Gift $gift = null,
        
        /** @var int|null Optional. Number of months the gifted Telegram Premium subscription will be active for; for “premium_purchase” transactions only */
        public null|int $premium_subscription_duration = null,
        
        
    ) { }
}
