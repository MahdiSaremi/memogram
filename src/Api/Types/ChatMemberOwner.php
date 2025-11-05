<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatMemberOwner extends ChatMember
{
    use Concerns\Data;

    /** @var string The member's status in the chat, always “creator” */
    public string $status = 'creator';

    public function __construct(
        /** @var User Information about the user */
        public User $user,
        
        /** @var bool True, if the user's presence in the chat is hidden */
        public bool $is_anonymous,
        
        /** @var string|null Optional. Custom title for this user */
        public null|string $custom_title = null,
        
        
    ) { }
}
