<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;


class BusinessMessagesDeleted
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique identifier of the business connection */
        public string $business_connection_id,
        
        /** @var Chat Information about a chat in the business account. The bot may not have access to the chat or the corresponding user. */
        public Chat $chat,
        
        /** @var array<\MemoGram\Api\Types\int> The list of identifiers of deleted messages in the chat of the business account */
        public array $message_ids,
        
        
    ) { }
}
