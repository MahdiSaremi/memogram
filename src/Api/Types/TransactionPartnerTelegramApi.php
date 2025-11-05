<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class TransactionPartnerTelegramApi
{
    use Concerns\Data;

    /** @var string Type of the transaction partner, always “telegram_api” */
    public string $type = 'telegram_api';

    public function __construct(
        /** @var int The number of successful requests that exceeded regular limits and were therefore billed */
        public int $request_count,
        
        
    ) { }
}
