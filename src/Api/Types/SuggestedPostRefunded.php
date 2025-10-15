<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Message;


class SuggestedPostRefunded
{
    use Concerns\Data;

    public function __construct(
        /** @var Message|null Optional. Message containing the suggested post. Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply. */
        public null|Message $suggested_post_message = null,
        
        /** @var string Reason for the refund. Currently, one of “post_deleted” if the post was deleted within 24 hours of being posted or removed from scheduled messages without being posted, or “payment_refunded” if the payer refunded their payment. */
        public string $reason,
        
        
    ) { }
}
