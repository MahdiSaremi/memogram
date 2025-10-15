<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;


class MessageOriginChannel
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the message origin, always “channel” */
        public string $type,
        
        /** @var int Date the message was sent originally in Unix time */
        public int $date,
        
        /** @var Chat Channel chat to which the message was originally sent */
        public Chat $chat,
        
        /** @var int Unique message identifier inside the chat */
        public int $message_id,
        
        /** @var string|null Optional. Signature of the original post author */
        public null|string $author_signature = null,
        
        
    ) { }
}
