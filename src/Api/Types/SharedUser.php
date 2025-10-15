<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class SharedUser
{
    use Concerns\Data;

    public function __construct(
        /** @var int Identifier of the shared user. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so 64-bit integers or double-precision float types are safe for storing these identifiers. The bot may not have access to the user and could be unable to use this identifier, unless the user is already known to the bot by some other means. */
        public int $user_id,
        
        /** @var string|null Optional. First name of the user, if the name was requested by the bot */
        public null|string $first_name = null,
        
        /** @var string|null Optional. Last name of the user, if the name was requested by the bot */
        public null|string $last_name = null,
        
        /** @var string|null Optional. Username of the user, if the username was requested by the bot */
        public null|string $username = null,
        
        /** @var array<\MemoGram\Api\Types\PhotoSize>|null Optional. Available sizes of the chat photo, if the photo was requested by the bot */
        public null|array $photo = null,
        
        
    ) { }
}
