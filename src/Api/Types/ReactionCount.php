<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\ReactionType;


class ReactionCount
{
    use Concerns\Data;

    public function __construct(
        /** @var ReactionType Type of the reaction */
        public ReactionType $type,
        
        /** @var int Number of times the reaction was added */
        public int $total_count,
        
        
    ) { }
}
