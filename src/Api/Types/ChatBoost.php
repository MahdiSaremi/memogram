<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\ChatBoostSource;


class ChatBoost
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique identifier of the boost */
        public string $boost_id,
        
        /** @var int Point in time (Unix timestamp) when the chat was boosted */
        public int $add_date,
        
        /** @var int Point in time (Unix timestamp) when the boost will automatically expire, unless the booster's Telegram Premium subscription is prolonged */
        public int $expiration_date,
        
        /** @var ChatBoostSource Source of the added boost */
        public ChatBoostSource $source,
        
        
    ) { }
}
