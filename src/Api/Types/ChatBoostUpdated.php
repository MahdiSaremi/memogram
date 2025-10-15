<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\ChatBoost;


class ChatBoostUpdated
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat Chat which was boosted */
        public Chat $chat,
        
        /** @var ChatBoost Information about the chat boost */
        public ChatBoost $boost,
        
        
    ) { }
}
