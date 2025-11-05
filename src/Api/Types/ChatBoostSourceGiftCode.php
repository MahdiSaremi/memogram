<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatBoostSourceGiftCode extends ChatBoostSource
{
    use Concerns\Data;

    /** @var string Source of the boost, always “gift_code” */
    public string $source = 'gift_code';

    public function __construct(
        /** @var User User for which the gift code was created */
        public User $user,
        
        
    ) { }
}
