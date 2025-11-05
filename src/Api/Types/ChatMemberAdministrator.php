<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatMemberAdministrator extends ChatMember
{
    use Concerns\Data;

    /** @var string The member's status in the chat, always “administrator” */
    public string $status = 'administrator';

    public function __construct(
        /** @var User Information about the user */
        public User $user,
        
        /** @var bool True, if the bot is allowed to edit administrator privileges of that user */
        public bool $can_be_edited,
        
        /** @var bool True, if the user's presence in the chat is hidden */
        public bool $is_anonymous,
        
        /** @var bool True, if the administrator can access the chat event log, get boost list, see hidden supergroup and channel members, report spam messages, ignore slow mode, and send messages to the chat without paying Telegram Stars. Implied by any other administrator privilege. */
        public bool $can_manage_chat,
        
        /** @var bool True, if the administrator can delete messages of other users */
        public bool $can_delete_messages,
        
        /** @var bool True, if the administrator can manage video chats */
        public bool $can_manage_video_chats,
        
        /** @var bool True, if the administrator can restrict, ban or unban chat members, or access supergroup statistics */
        public bool $can_restrict_members,
        
        /** @var bool True, if the administrator can add new administrators with a subset of their own privileges or demote administrators that they have promoted, directly or indirectly (promoted by administrators that were appointed by the user) */
        public bool $can_promote_members,
        
        /** @var bool True, if the user is allowed to change the chat title, photo and other settings */
        public bool $can_change_info,
        
        /** @var bool True, if the user is allowed to invite new users to the chat */
        public bool $can_invite_users,
        
        /** @var bool True, if the administrator can post stories to the chat */
        public bool $can_post_stories,
        
        /** @var bool True, if the administrator can edit stories posted by other users, post stories to the chat page, pin chat stories, and access the chat's story archive */
        public bool $can_edit_stories,
        
        /** @var bool True, if the administrator can delete stories posted by other users */
        public bool $can_delete_stories,
        
        /** @var bool|null Optional. True, if the administrator can post messages in the channel, approve suggested posts, or access channel statistics; for channels only */
        public null|bool $can_post_messages = null,
        
        /** @var bool|null Optional. True, if the administrator can edit messages of other users and can pin messages; for channels only */
        public null|bool $can_edit_messages = null,
        
        /** @var bool|null Optional. True, if the user is allowed to pin messages; for groups and supergroups only */
        public null|bool $can_pin_messages = null,
        
        /** @var bool|null Optional. True, if the user is allowed to create, rename, close, and reopen forum topics; for supergroups only */
        public null|bool $can_manage_topics = null,
        
        /** @var bool|null Optional. True, if the administrator can manage direct messages of the channel and decline suggested posts; for channels only */
        public null|bool $can_manage_direct_messages = null,
        
        /** @var string|null Optional. Custom title for this user */
        public null|string $custom_title = null,
        
        
    ) { }
}
