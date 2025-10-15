<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\User;
use MemoGram\Api\Types\ChatMember;
use MemoGram\Api\Types\ChatInviteLink;


class ChatMemberUpdated
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat Chat the user belongs to */
        public Chat $chat,
        
        /** @var User Performer of the action, which resulted in the change */
        public User $from,
        
        /** @var int Date the change was done in Unix time */
        public int $date,
        
        /** @var ChatMember Previous information about the chat member */
        public ChatMember $old_chat_member,
        
        /** @var ChatMember New information about the chat member */
        public ChatMember $new_chat_member,
        
        /** @var ChatInviteLink|null Optional. Chat invite link, which was used by the user to join the chat; for joining by invite link events only. */
        public null|ChatInviteLink $invite_link = null,
        
        /** @var bool|null Optional. True, if the user joined the chat after sending a direct join request without using an invite link and being approved by an administrator */
        public null|bool $via_join_request = null,
        
        /** @var bool|null Optional. True, if the user joined the chat via a chat folder invite link */
        public null|bool $via_chat_folder_invite_link = null,
        
        
    ) { }
}
