<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class RevenueWithdrawalStateSucceeded
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the state, always “succeeded” */
        public string $type,
        
        /** @var int Date the withdrawal was completed in Unix time */
        public int $date,
        
        /** @var string An HTTPS URL that can be used to see transaction details */
        public string $url,
        
        
    ) { }
}
