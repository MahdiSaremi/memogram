<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatMemberLeft extends ChatMember
{
    use Concerns\Data;

    /** @var string The member's status in the chat, always “left” */
    public string $status = 'left';

    public function __construct(
        /** @var User Information about the user */
        public User $user,
        
        
    ) { }
}
