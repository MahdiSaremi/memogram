<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;
use MemoGram\Api\Types\BusinessBotRights;


class BusinessConnection
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique identifier of the business connection */
        public string $id,
        
        /** @var User Business account user that created the business connection */
        public User $user,
        
        /** @var int Identifier of a private chat with the user who created the business connection. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. */
        public int $user_chat_id,
        
        /** @var int Date the connection was established in Unix time */
        public int $date,
        
        /** @var BusinessBotRights|null Optional. Rights of the business bot */
        public null|BusinessBotRights $rights = null,
        
        /** @var bool True, if the connection is active */
        public bool $is_enabled,
        
        
    ) { }
}
