<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ReactionTypeEmoji extends ReactionType
{
    use Concerns\Data;

    /** @var string Type of the reaction, always “emoji” */
    public string $type = 'emoji';

    public function __construct(
        /** @var string Reaction emoji. Currently, it can be one of "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "" */
        public string $emoji,
        
        
    ) { }
}
