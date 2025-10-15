<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ReactionTypeCustomEmoji
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the reaction, always “custom_emoji” */
        public string $type,
        
        /** @var string Custom emoji identifier */
        public string $custom_emoji_id,
        
        
    ) { }
}
