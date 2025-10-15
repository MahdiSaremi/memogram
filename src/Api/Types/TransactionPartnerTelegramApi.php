<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class TransactionPartnerTelegramApi
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the transaction partner, always “telegram_api” */
        public string $type,
        
        /** @var int The number of successful requests that exceeded regular limits and were therefore billed */
        public int $request_count,
        
        
    ) { }
}
