<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\SuggestedPostPrice;


class SuggestedPostInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var string State of the suggested post. Currently, it can be one of “pending”, “approved”, “declined”. */
        public string $state,
        
        /** @var SuggestedPostPrice|null Optional. Proposed price of the post. If the field is omitted, then the post is unpaid. */
        public null|SuggestedPostPrice $price = null,
        
        /** @var int|null Optional. Proposed send date of the post. If the field is omitted, then the post can be published at any time within 30 days at the sole discretion of the user or administrator who approves it. */
        public null|int $send_date = null,
        
        
    ) { }
}
