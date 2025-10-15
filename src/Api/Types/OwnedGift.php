<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Gift;
use MemoGram\Api\Types\User;


class OwnedGift
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the gift, always “regular” */
        public string $type,
        
        /** @var Gift Information about the regular gift */
        public Gift $gift,
        
        /** @var string|null Optional. Unique identifier of the gift for the bot; for gifts received on behalf of business accounts only */
        public null|string $owned_gift_id = null,
        
        /** @var User|null Optional. Sender of the gift if it is a known user */
        public null|User $sender_user = null,
        
        /** @var int Date the gift was sent in Unix time */
        public int $send_date,
        
        /** @var string|null Optional. Text of the message that was added to the gift */
        public null|string $text = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities that appear in the text */
        public null|array $entities = null,
        
        /** @var bool|null Optional. True, if the sender and gift text are shown only to the gift receiver; otherwise, everyone will be able to see them */
        public null|bool $is_private = null,
        
        /** @var bool|null Optional. True, if the gift is displayed on the account's profile page; for gifts received on behalf of business accounts only */
        public null|bool $is_saved = null,
        
        /** @var bool|null Optional. True, if the gift can be upgraded to a unique gift; for gifts received on behalf of business accounts only */
        public null|bool $can_be_upgraded = null,
        
        /** @var bool|null Optional. True, if the gift was refunded and isn't available anymore */
        public null|bool $was_refunded = null,
        
        /** @var int|null Optional. Number of Telegram Stars that can be claimed by the receiver instead of the gift; omitted if the gift cannot be converted to Telegram Stars */
        public null|int $convert_star_count = null,
        
        /** @var int|null Optional. Number of Telegram Stars that were paid by the sender for the ability to upgrade the gift */
        public null|int $prepaid_upgrade_star_count = null,
        
        
    ) { }
}
