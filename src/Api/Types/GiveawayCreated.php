<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class GiveawayCreated
{
    use Concerns\Data;

    public function __construct(
        /** @var int|null Optional. The number of Telegram Stars to be split between giveaway winners; for Telegram Star giveaways only */
        public null|int $prize_star_count = null,
        
        
    ) { }
}
