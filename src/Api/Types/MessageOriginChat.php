<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;


class MessageOriginChat extends MessageOrigin
{
    use Concerns\Data;

    /** @var string Type of the message origin, always “chat” */
    public string $type = 'chat';

    public function __construct(
        /** @var int Date the message was sent originally in Unix time */
        public int $date,
        
        /** @var Chat Chat that sent the message originally */
        public Chat $sender_chat,
        
        /** @var string|null Optional. For messages originally sent by an anonymous chat administrator, original message author signature */
        public null|string $author_signature = null,
        
        
    ) { }
}
