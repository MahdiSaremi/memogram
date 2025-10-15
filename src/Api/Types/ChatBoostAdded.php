<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ChatBoostAdded
{
    use Concerns\Data;

    public function __construct(
        /** @var int Number of boosts added by the user */
        public int $boost_count,
        
        
    ) { }
}
