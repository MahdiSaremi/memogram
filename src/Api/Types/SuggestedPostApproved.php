<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\SuggestedPostPrice;


class SuggestedPostApproved
{
    use Concerns\Data;

    public function __construct(
        /** @var Message|null Optional. Message containing the suggested post. Note that the Message object in this field will not contain the reply_to_message field even if it itself is a reply. */
        public null|Message $suggested_post_message = null,
        
        /** @var SuggestedPostPrice|null Optional. Amount paid for the post */
        public null|SuggestedPostPrice $price = null,
        
        /** @var int Date when the post will be published */
        public int $send_date,
        
        
    ) { }
}
