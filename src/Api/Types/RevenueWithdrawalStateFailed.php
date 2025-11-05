<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class RevenueWithdrawalStateFailed extends RevenueWithdrawalState
{
    use Concerns\Data;

    /** @var string Type of the state, always “failed” */
    public string $type = 'failed';

    public function __construct(

    ) { }
}
