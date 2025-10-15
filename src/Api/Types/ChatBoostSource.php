<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatBoostSource
{
    use Concerns\Data;

    public function __construct(
        /** @var string Source of the boost, always “premium” */
        public string $source,
        
        /** @var User User that boosted the chat */
        public User $user,
        
        
    ) { }
}
