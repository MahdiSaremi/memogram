<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\UniqueGift;
use MemoGram\Api\Types\User;


class OwnedGiftUnique extends OwnedGift
{
    use Concerns\Data;

    /** @var string Type of the gift, always “unique” */
    public string $type = 'unique';

    public function __construct(
        /** @var UniqueGift Information about the unique gift */
        public UniqueGift $gift,
        
        /** @var string|null Optional. Unique identifier of the received gift for the bot; for gifts received on behalf of business accounts only */
        public null|string $owned_gift_id = null,
        
        /** @var User|null Optional. Sender of the gift if it is a known user */
        public null|User $sender_user = null,
        
        /** @var int Date the gift was sent in Unix time */
        public int $send_date,
        
        /** @var bool|null Optional. True, if the gift is displayed on the account's profile page; for gifts received on behalf of business accounts only */
        public null|bool $is_saved = null,
        
        /** @var bool|null Optional. True, if the gift can be transferred to another owner; for gifts received on behalf of business accounts only */
        public null|bool $can_be_transferred = null,
        
        /** @var int|null Optional. Number of Telegram Stars that must be paid to transfer the gift; omitted if the bot cannot transfer the gift */
        public null|int $transfer_star_count = null,
        
        /** @var int|null Optional. Point in time (Unix timestamp) when the gift can be transferred. If it is in the past, then the gift can be transferred now */
        public null|int $next_transfer_date = null,
        
        
    ) { }
}
