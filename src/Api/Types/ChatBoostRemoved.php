<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\ChatBoostSource;


class ChatBoostRemoved
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat Chat which was boosted */
        public Chat $chat,
        
        /** @var string Unique identifier of the boost */
        public string $boost_id,
        
        /** @var int Point in time (Unix timestamp) when the boost was removed */
        public int $remove_date,
        
        /** @var ChatBoostSource Source of the removed boost */
        public ChatBoostSource $source,
        
        
    ) { }
}
