<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatBoostSourcePremium extends ChatBoostSource
{
    use Concerns\Data;

    /** @var string Source of the boost, always “premium” */
    public string $source = 'premium';

    public function __construct(
        /** @var User User that boosted the chat */
        public User $user,
        
        
    ) { }
}
