<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class RevenueWithdrawalStateSucceeded extends RevenueWithdrawalState
{
    use Concerns\Data;

    /** @var string Type of the state, always “succeeded” */
    public string $type = 'succeeded';

    public function __construct(
        /** @var int Date the withdrawal was completed in Unix time */
        public int $date,
        
        /** @var string An HTTPS URL that can be used to see transaction details */
        public string $url,
        
        
    ) { }
}
