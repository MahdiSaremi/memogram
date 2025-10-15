<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class SwitchInlineQueryChosenChat
{
    use Concerns\Data;

    public function __construct(
        /** @var string|null Optional. The default inline query to be inserted in the input field. If left empty, only the bot's username will be inserted */
        public null|string $query = null,
        
        /** @var bool|null Optional. True, if private chats with users can be chosen */
        public null|bool $allow_user_chats = null,
        
        /** @var bool|null Optional. True, if private chats with bots can be chosen */
        public null|bool $allow_bot_chats = null,
        
        /** @var bool|null Optional. True, if group and supergroup chats can be chosen */
        public null|bool $allow_group_chats = null,
        
        /** @var bool|null Optional. True, if channel chats can be chosen */
        public null|bool $allow_channel_chats = null,
        
        
    ) { }
}
