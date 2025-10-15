<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatMemberMember
{
    use Concerns\Data;

    public function __construct(
        /** @var string The member's status in the chat, always “member” */
        public string $status,
        
        /** @var User Information about the user */
        public User $user,
        
        /** @var int|null Optional. Date when the user's subscription will expire; Unix time */
        public null|int $until_date = null,
        
        
    ) { }
}
