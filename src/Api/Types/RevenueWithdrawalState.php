<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class RevenueWithdrawalState
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the state, always “pending” */
        public string $type,
        
        
    ) { }
}
