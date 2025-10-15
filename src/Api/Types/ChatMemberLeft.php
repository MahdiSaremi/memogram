<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatMemberLeft
{
    use Concerns\Data;

    public function __construct(
        /** @var string The member's status in the chat, always “left” */
        public string $status,
        
        /** @var User Information about the user */
        public User $user,
        
        
    ) { }
}
