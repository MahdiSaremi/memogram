<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class RevenueWithdrawalStateFailed
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the state, always “failed” */
        public string $type,
        
        
    ) { }
}
