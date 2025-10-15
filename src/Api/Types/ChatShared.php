<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class ChatShared
{
    use Concerns\Data;

    public function __construct(
        /** @var int Identifier of the request */
        public int $request_id,
        
        /** @var int Identifier of the shared chat. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. The bot may not have access to the chat and could be unable to use this identifier, unless the chat is already known to the bot by some other means. */
        public int $chat_id,
        
        /** @var string|null Optional. Title of the chat, if the title was requested by the bot. */
        public null|string $title = null,
        
        /** @var string|null Optional. Username of the chat, if the username was requested by the bot and available. */
        public null|string $username = null,
        
        /** @var array<\MemoGram\Api\Types\PhotoSize>|null Optional. Available sizes of the chat photo, if the photo was requested by the bot */
        public null|array $photo = null,
        
        
    ) { }
}
