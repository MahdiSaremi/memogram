<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class RevenueWithdrawalStatePending extends RevenueWithdrawalState
{
    use Concerns\Data;

    /** @var string Type of the state, always “pending” */
    public string $type = 'pending';

    public function __construct(

    ) { }
}
