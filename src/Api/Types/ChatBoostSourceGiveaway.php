<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class ChatBoostSourceGiveaway
{
    use Concerns\Data;

    public function __construct(
        /** @var string Source of the boost, always “giveaway” */
        public string $source,
        
        /** @var int Identifier of a message in the chat with the giveaway; the message could have been deleted already. May be 0 if the message isn't sent yet. */
        public int $giveaway_message_id,
        
        /** @var User|null Optional. User that won the prize in the giveaway if any; for Telegram Premium giveaways only */
        public null|User $user = null,
        
        /** @var int|null Optional. The number of Telegram Stars to be split between giveaway winners; for Telegram Star giveaways only */
        public null|int $prize_star_count = null,
        
        /** @var bool|null Optional. True, if the giveaway was completed, but there was no user to win the prize */
        public null|bool $is_unclaimed = null,
        
        
    ) { }
}
