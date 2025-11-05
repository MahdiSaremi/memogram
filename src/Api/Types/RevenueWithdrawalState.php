<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;


abstract class RevenueWithdrawalState
{
    public static function makeDynamic(array $data): self
    {
        return match ($data['type']) {
            'pending' => RevenueWithdrawalStatePending::makeFromArray($data),
            'succeeded' => RevenueWithdrawalStateSucceeded::makeFromArray($data),
            'failed' => RevenueWithdrawalStateFailed::makeFromArray($data),
        };
    }
}
