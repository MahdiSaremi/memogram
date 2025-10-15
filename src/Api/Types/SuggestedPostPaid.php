<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\StarAmount;


class SuggestedPostPaid
{
    use Concerns\Data;

    public function __construct(
        /** @var Message|null Optional. Message containing the suggested post. Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply. */
        public null|Message $suggested_post_message = null,
        
        /** @var string Currency in which the payment was made. Currently, one of “XTR” for Telegram Stars or “TON” for toncoins */
        public string $currency,
        
        /** @var int|null Optional. The amount of the currency that was received by the channel in nanotoncoins; for payments in toncoins only */
        public null|int $amount = null,
        
        /** @var StarAmount|null Optional. The amount of Telegram Stars that was received by the channel; for payments in Telegram Stars only */
        public null|StarAmount $star_amount = null,
        
        
    ) { }
}
