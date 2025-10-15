<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\User;
use MemoGram\Api\Types\ChatInviteLink;


class ChatJoinRequest
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat Chat to which the request was sent */
        public Chat $chat,
        
        /** @var User User that sent the join request */
        public User $from,
        
        /** @var int Identifier of a private chat with the user who sent the join request. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. The bot can use this identifier for 5 minutes to send messages until the join request is processed, assuming no other administrator contacted the user. */
        public int $user_chat_id,
        
        /** @var int Date the request was sent in Unix time */
        public int $date,
        
        /** @var string|null Optional. Bio of the user. */
        public null|string $bio = null,
        
        /** @var ChatInviteLink|null Optional. Chat invite link that was used by the user to send the join request */
        public null|ChatInviteLink $invite_link = null,
        
        
    ) { }
}
