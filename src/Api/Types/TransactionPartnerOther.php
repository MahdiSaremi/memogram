<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class TransactionPartnerOther extends TransactionPartner
{
    use Concerns\Data;

    /** @var string Type of the transaction partner, always “other” */
    public string $type = 'other';

    public function __construct(

    ) { }
}
