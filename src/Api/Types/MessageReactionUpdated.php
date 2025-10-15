<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\User;


class MessageReactionUpdated
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat The chat containing the message the user reacted to */
        public Chat $chat,
        
        /** @var int Unique identifier of the message inside the chat */
        public int $message_id,
        
        /** @var User|null Optional. The user that changed the reaction, if the user isn't anonymous */
        public null|User $user = null,
        
        /** @var Chat|null Optional. The chat on behalf of which the reaction was changed, if the user is anonymous */
        public null|Chat $actor_chat = null,
        
        /** @var int Date of the change in Unix time */
        public int $date,
        
        /** @var array<\MemoGram\Api\Types\ReactionType> Previous list of reaction types that were set by the user */
        public array $old_reaction,
        
        /** @var array<\MemoGram\Api\Types\ReactionType> New list of reaction types that have been set by the user */
        public array $new_reaction,
        
        
    ) { }
}
