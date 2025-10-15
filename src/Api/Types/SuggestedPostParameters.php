<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\SuggestedPostPrice;


class SuggestedPostParameters
{
    use Concerns\Data;

    public function __construct(
        /** @var SuggestedPostPrice|null Optional. Proposed price for the post. If the field is omitted, then the post is unpaid. */
        public null|SuggestedPostPrice $price = null,
        
        /** @var int|null Optional. Proposed send date of the post. If specified, then the date must be between 300 second and 2678400 seconds (30 days) in the future. If the field is omitted, then the post can be published at any time within 30 days at the sole discretion of the user who approves it. */
        public null|int $send_date = null,
        
        
    ) { }
}
