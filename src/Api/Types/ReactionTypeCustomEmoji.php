<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ReactionTypeCustomEmoji extends ReactionType
{
    use Concerns\Data;

    /** @var string Type of the reaction, always “custom_emoji” */
    public string $type = 'custom_emoji';

    public function __construct(
        /** @var string Custom emoji identifier */
        public string $custom_emoji_id,
        
        
    ) { }
}
