<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class StarTransactions
{
    use Concerns\Data;

    public function __construct(
        /** @var array<\MemoGram\Api\Types\StarTransaction> The list of transactions */
        public array $transactions,
        
        
    ) { }
}
