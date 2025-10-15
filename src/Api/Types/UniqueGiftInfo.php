<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\UniqueGift;


class UniqueGiftInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var UniqueGift Information about the gift */
        public UniqueGift $gift,
        
        /** @var string Origin of the gift. Currently, either “upgrade” for gifts upgraded from regular gifts, “transfer” for gifts transferred from other users or channels, or “resale” for gifts bought from other users */
        public string $origin,
        
        /** @var int|null Optional. For gifts bought from other users, the price paid for the gift */
        public null|int $last_resale_star_count = null,
        
        /** @var string|null Optional. Unique identifier of the received gift for the bot; only present for gifts received on behalf of business accounts */
        public null|string $owned_gift_id = null,
        
        /** @var int|null Optional. Number of Telegram Stars that must be paid to transfer the gift; omitted if the bot cannot transfer the gift */
        public null|int $transfer_star_count = null,
        
        /** @var int|null Optional. Point in time (Unix timestamp) when the gift can be transferred. If it is in the past, then the gift can be transferred now */
        public null|int $next_transfer_date = null,
        
        
    ) { }
}
