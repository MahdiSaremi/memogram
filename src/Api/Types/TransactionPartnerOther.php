<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class TransactionPartnerOther
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the transaction partner, always “other” */
        public string $type,
        
        
    ) { }
}
