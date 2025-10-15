<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatBoostSourceGiftCode
{
    use Concerns\Data;

    public function __construct(
        /** @var string Source of the boost, always “gift_code” */
        public string $source,
        
        /** @var User User for which the gift code was created */
        public User $user,
        
        
    ) { }
}
