<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class PaidMediaPurchased
{
    use Concerns\Data;

    public function __construct(
        /** @var User User who purchased the media */
        public User $from,
        
        /** @var string Bot-specified paid media payload */
        public string $paid_media_payload,
        
        
    ) { }
}
