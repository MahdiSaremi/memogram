<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;


class MessageReactionCountUpdated
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat The chat containing the message */
        public Chat $chat,
        
        /** @var int Unique message identifier inside the chat */
        public int $message_id,
        
        /** @var int Date of the change in Unix time */
        public int $date,
        
        /** @var array<\MemoGram\Api\Types\ReactionCount> List of reactions that are present on the message */
        public array $reactions,
        
        
    ) { }
}
