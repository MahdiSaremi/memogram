<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class User
{
    use Concerns\Data;

    public function __construct(
        /** @var int Unique identifier for this user or bot. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. */
        public int $id,
        
        /** @var bool True, if this user is a bot */
        public bool $is_bot,
        
        /** @var string User's or bot's first name */
        public string $first_name,
        
        /** @var string|null Optional. User's or bot's last name */
        public null|string $last_name = null,
        
        /** @var string|null Optional. User's or bot's username */
        public null|string $username = null,
        
        /** @var string|null Optional. IETF language tag of the user's language */
        public null|string $language_code = null,
        
        /** @var bool|null Optional. True, if this user is a Telegram Premium user */
        public null|bool $is_premium = null,
        
        /** @var bool|null Optional. True, if this user added the bot to the attachment menu */
        public null|bool $added_to_attachment_menu = null,
        
        /** @var bool|null Optional. True, if the bot can be invited to groups. Returned only in getMe. */
        public null|bool $can_join_groups = null,
        
        /** @var bool|null Optional. True, if privacy mode is disabled for the bot. Returned only in getMe. */
        public null|bool $can_read_all_group_messages = null,
        
        /** @var bool|null Optional. True, if the bot supports inline queries. Returned only in getMe. */
        public null|bool $supports_inline_queries = null,
        
        /** @var bool|null Optional. True, if the bot can be connected to a Telegram Business account to receive its messages. Returned only in getMe. */
        public null|bool $can_connect_to_business = null,
        
        /** @var bool|null Optional. True, if the bot has a main Web App. Returned only in getMe. */
        public null|bool $has_main_web_app = null,
        
        
    ) { }
}
