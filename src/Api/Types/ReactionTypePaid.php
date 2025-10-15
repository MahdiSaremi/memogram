<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ReactionTypePaid
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the reaction, always “paid” */
        public string $type,
        
        
    ) { }
}
