<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\ReactionType;


class StoryAreaTypeSuggestedReaction
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the area, always “suggested_reaction” */
        public string $type,
        
        /** @var ReactionType Type of the reaction */
        public ReactionType $reaction_type,
        
        /** @var bool|null Optional. Pass True if the reaction area has a dark background */
        public null|bool $is_dark = null,
        
        /** @var bool|null Optional. Pass True if reaction area corner is flipped */
        public null|bool $is_flipped = null,
        
        
    ) { }
}
