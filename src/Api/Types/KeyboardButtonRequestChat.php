<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\ChatAdministratorRights;


class KeyboardButtonRequestChat
{
    use Concerns\Data;

    public function __construct(
        /** @var int Signed 32-bit identifier of the request, which will be received back in the ChatShared object. Must be unique within the message */
        public int $request_id,
        
        /** @var bool Pass True to request a channel chat, pass False to request a group or a supergroup chat. */
        public bool $chat_is_channel,
        
        /** @var bool|null Optional. Pass True to request a forum supergroup, pass False to request a non-forum chat. If not specified, no additional restrictions are applied. */
        public null|bool $chat_is_forum = null,
        
        /** @var bool|null Optional. Pass True to request a supergroup or a channel with a username, pass False to request a chat without a username. If not specified, no additional restrictions are applied. */
        public null|bool $chat_has_username = null,
        
        /** @var bool|null Optional. Pass True to request a chat owned by the user. Otherwise, no additional restrictions are applied. */
        public null|bool $chat_is_created = null,
        
        /** @var ChatAdministratorRights|null Optional. A JSON-serialized object listing the required administrator rights of the user in the chat. The rights must be a superset of bot_administrator_rights. If not specified, no additional restrictions are applied. */
        public null|ChatAdministratorRights $user_administrator_rights = null,
        
        /** @var ChatAdministratorRights|null Optional. A JSON-serialized object listing the required administrator rights of the bot in the chat. The rights must be a subset of user_administrator_rights. If not specified, no additional restrictions are applied. */
        public null|ChatAdministratorRights $bot_administrator_rights = null,
        
        /** @var bool|null Optional. Pass True to request a chat with the bot as a member. Otherwise, no additional restrictions are applied. */
        public null|bool $bot_is_member = null,
        
        /** @var bool|null Optional. Pass True to request the chat's title */
        public null|bool $request_title = null,
        
        /** @var bool|null Optional. Pass True to request the chat's username */
        public null|bool $request_username = null,
        
        /** @var bool|null Optional. Pass True to request the chat's photo */
        public null|bool $request_photo = null,
        
        
    ) { }
}
