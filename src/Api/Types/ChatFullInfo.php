<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\ChatPhoto;
use MemoGram\Api\Types\Birthdate;
use MemoGram\Api\Types\BusinessIntro;
use MemoGram\Api\Types\BusinessLocation;
use MemoGram\Api\Types\BusinessOpeningHours;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\Message;
use MemoGram\Api\Types\ChatPermissions;
use MemoGram\Api\Types\AcceptedGiftTypes;
use MemoGram\Api\Types\ChatLocation;


class ChatFullInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var int Unique identifier for this chat. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier. */
        public int $id,
        
        /** @var string Type of the chat, can be either “private”, “group”, “supergroup” or “channel” */
        public string $type,
        
        /** @var string|null Optional. Title, for supergroups, channels and group chats */
        public null|string $title = null,
        
        /** @var string|null Optional. Username, for private chats, supergroups and channels if available */
        public null|string $username = null,
        
        /** @var string|null Optional. First name of the other party in a private chat */
        public null|string $first_name = null,
        
        /** @var string|null Optional. Last name of the other party in a private chat */
        public null|string $last_name = null,
        
        /** @var bool|null Optional. True, if the supergroup chat is a forum (has topics enabled) */
        public null|bool $is_forum = null,
        
        /** @var bool|null Optional. True, if the chat is the direct messages chat of a channel */
        public null|bool $is_direct_messages = null,
        
        /** @var int Identifier of the accent color for the chat name and backgrounds of the chat photo, reply header, and link preview. See accent colors for more details. */
        public int $accent_color_id,
        
        /** @var int The maximum number of reactions that can be set on a message in the chat */
        public int $max_reaction_count,
        
        /** @var ChatPhoto|null Optional. Chat photo */
        public null|ChatPhoto $photo = null,
        
        /** @var array<\MemoGram\Api\Types\string>|null Optional. If non-empty, the list of all active chat usernames; for private chats, supergroups and channels */
        public null|array $active_usernames = null,
        
        /** @var Birthdate|null Optional. For private chats, the date of birth of the user */
        public null|Birthdate $birthdate = null,
        
        /** @var BusinessIntro|null Optional. For private chats with business accounts, the intro of the business */
        public null|BusinessIntro $business_intro = null,
        
        /** @var BusinessLocation|null Optional. For private chats with business accounts, the location of the business */
        public null|BusinessLocation $business_location = null,
        
        /** @var BusinessOpeningHours|null Optional. For private chats with business accounts, the opening hours of the business */
        public null|BusinessOpeningHours $business_opening_hours = null,
        
        /** @var Chat|null Optional. For private chats, the personal channel of the user */
        public null|Chat $personal_chat = null,
        
        /** @var Chat|null Optional. Information about the corresponding channel chat; for direct messages chats only */
        public null|Chat $parent_chat = null,
        
        /** @var array<\MemoGram\Api\Types\ReactionType>|null Optional. List of available reactions allowed in the chat. If omitted, then all emoji reactions are allowed. */
        public null|array $available_reactions = null,
        
        /** @var string|null Optional. Custom emoji identifier of the emoji chosen by the chat for the reply header and link preview background */
        public null|string $background_custom_emoji_id = null,
        
        /** @var int|null Optional. Identifier of the accent color for the chat's profile background. See profile accent colors for more details. */
        public null|int $profile_accent_color_id = null,
        
        /** @var string|null Optional. Custom emoji identifier of the emoji chosen by the chat for its profile background */
        public null|string $profile_background_custom_emoji_id = null,
        
        /** @var string|null Optional. Custom emoji identifier of the emoji status of the chat or the other party in a private chat */
        public null|string $emoji_status_custom_emoji_id = null,
        
        /** @var int|null Optional. Expiration date of the emoji status of the chat or the other party in a private chat, in Unix time, if any */
        public null|int $emoji_status_expiration_date = null,
        
        /** @var string|null Optional. Bio of the other party in a private chat */
        public null|string $bio = null,
        
        /** @var bool|null Optional. True, if privacy settings of the other party in the private chat allows to use tg://user?id=<user_id> links only in chats with the user */
        public null|bool $has_private_forwards = null,
        
        /** @var bool|null Optional. True, if the privacy settings of the other party restrict sending voice and video note messages in the private chat */
        public null|bool $has_restricted_voice_and_video_messages = null,
        
        /** @var bool|null Optional. True, if users need to join the supergroup before they can send messages */
        public null|bool $join_to_send_messages = null,
        
        /** @var bool|null Optional. True, if all users directly joining the supergroup without using an invite link need to be approved by supergroup administrators */
        public null|bool $join_by_request = null,
        
        /** @var string|null Optional. Description, for groups, supergroups and channel chats */
        public null|string $description = null,
        
        /** @var string|null Optional. Primary invite link, for groups, supergroups and channel chats */
        public null|string $invite_link = null,
        
        /** @var Message|null Optional. The most recent pinned message (by sending date) */
        public null|Message $pinned_message = null,
        
        /** @var ChatPermissions|null Optional. Default chat member permissions, for groups and supergroups */
        public null|ChatPermissions $permissions = null,
        
        /** @var AcceptedGiftTypes Information about types of gifts that are accepted by the chat or by the corresponding user for private chats */
        public AcceptedGiftTypes $accepted_gift_types,
        
        /** @var bool|null Optional. True, if paid media messages can be sent or forwarded to the channel chat. The field is available only for channel chats. */
        public null|bool $can_send_paid_media = null,
        
        /** @var int|null Optional. For supergroups, the minimum allowed delay between consecutive messages sent by each unprivileged user; in seconds */
        public null|int $slow_mode_delay = null,
        
        /** @var int|null Optional. For supergroups, the minimum number of boosts that a non-administrator user needs to add in order to ignore slow mode and chat permissions */
        public null|int $unrestrict_boost_count = null,
        
        /** @var int|null Optional. The time after which all messages sent to the chat will be automatically deleted; in seconds */
        public null|int $message_auto_delete_time = null,
        
        /** @var bool|null Optional. True, if aggressive anti-spam checks are enabled in the supergroup. The field is only available to chat administrators. */
        public null|bool $has_aggressive_anti_spam_enabled = null,
        
        /** @var bool|null Optional. True, if non-administrators can only get the list of bots and administrators in the chat */
        public null|bool $has_hidden_members = null,
        
        /** @var bool|null Optional. True, if messages from the chat can't be forwarded to other chats */
        public null|bool $has_protected_content = null,
        
        /** @var bool|null Optional. True, if new chat members will have access to old messages; available only to chat administrators */
        public null|bool $has_visible_history = null,
        
        /** @var string|null Optional. For supergroups, name of the group sticker set */
        public null|string $sticker_set_name = null,
        
        /** @var bool|null Optional. True, if the bot can change the group sticker set */
        public null|bool $can_set_sticker_set = null,
        
        /** @var string|null Optional. For supergroups, the name of the group's custom emoji sticker set. Custom emoji from this set can be used by all users and bots in the group. */
        public null|string $custom_emoji_sticker_set_name = null,
        
        /** @var int|null Optional. Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice versa; for supergroups and channel chats. This identifier may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier. */
        public null|int $linked_chat_id = null,
        
        /** @var ChatLocation|null Optional. For supergroups, the location to which the supergroup is connected */
        public null|ChatLocation $location = null,
        
        
    ) { }
}
