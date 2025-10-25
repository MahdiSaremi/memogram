<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Chat
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
        
        
    ) { }

    public const TYPE_PRIVATE = 'private';
    public const TYPE_GROUP = 'group';
    public const TYPE_SUPERGROUP = 'supergroup';
    public const TYPE_CHANNEL = 'channel';
}
