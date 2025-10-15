<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Message;


class GiveawayCompleted
{
    use Concerns\Data;

    public function __construct(
        /** @var int Number of winners in the giveaway */
        public int $winner_count,
        
        /** @var int|null Optional. Number of undistributed prizes */
        public null|int $unclaimed_prize_count = null,
        
        /** @var Message|null Optional. Message with the giveaway that was completed, if it wasn't deleted */
        public null|Message $giveaway_message = null,
        
        /** @var bool|null Optional. True, if the giveaway is a Telegram Star giveaway. Otherwise, currently, the giveaway is a Telegram Premium giveaway. */
        public null|bool $is_star_giveaway = null,
        
        
    ) { }
}
