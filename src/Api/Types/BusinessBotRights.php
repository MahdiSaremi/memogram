<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BusinessBotRights
{
    use Concerns\Data;

    public function __construct(
        /** @var bool|null Optional. True, if the bot can send and edit messages in the private chats that had incoming messages in the last 24 hours */
        public null|bool $can_reply = null,
        
        /** @var bool|null Optional. True, if the bot can mark incoming private messages as read */
        public null|bool $can_read_messages = null,
        
        /** @var bool|null Optional. True, if the bot can delete messages sent by the bot */
        public null|bool $can_delete_sent_messages = null,
        
        /** @var bool|null Optional. True, if the bot can delete all private messages in managed chats */
        public null|bool $can_delete_all_messages = null,
        
        /** @var bool|null Optional. True, if the bot can edit the first and last name of the business account */
        public null|bool $can_edit_name = null,
        
        /** @var bool|null Optional. True, if the bot can edit the bio of the business account */
        public null|bool $can_edit_bio = null,
        
        /** @var bool|null Optional. True, if the bot can edit the profile photo of the business account */
        public null|bool $can_edit_profile_photo = null,
        
        /** @var bool|null Optional. True, if the bot can edit the username of the business account */
        public null|bool $can_edit_username = null,
        
        /** @var bool|null Optional. True, if the bot can change the privacy settings pertaining to gifts for the business account */
        public null|bool $can_change_gift_settings = null,
        
        /** @var bool|null Optional. True, if the bot can view gifts and the amount of Telegram Stars owned by the business account */
        public null|bool $can_view_gifts_and_stars = null,
        
        /** @var bool|null Optional. True, if the bot can convert regular gifts owned by the business account to Telegram Stars */
        public null|bool $can_convert_gifts_to_stars = null,
        
        /** @var bool|null Optional. True, if the bot can transfer and upgrade gifts owned by the business account */
        public null|bool $can_transfer_and_upgrade_gifts = null,
        
        /** @var bool|null Optional. True, if the bot can transfer Telegram Stars received by the business account to its own account, or use them to upgrade and transfer gifts */
        public null|bool $can_transfer_stars = null,
        
        /** @var bool|null Optional. True, if the bot can post, edit and delete stories on behalf of the business account */
        public null|bool $can_manage_stories = null,
        
        
    ) { }
}
