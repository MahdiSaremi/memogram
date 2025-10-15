<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\RevenueWithdrawalState;


class TransactionPartnerFragment
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the transaction partner, always “fragment” */
        public string $type,
        
        /** @var RevenueWithdrawalState|null Optional. State of the transaction if the transaction is outgoing */
        public null|RevenueWithdrawalState $withdrawal_state = null,
        
        
    ) { }
}
