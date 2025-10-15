<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Gift;


class GiftInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var Gift Information about the gift */
        public Gift $gift,
        
        /** @var string|null Optional. Unique identifier of the received gift for the bot; only present for gifts received on behalf of business accounts */
        public null|string $owned_gift_id = null,
        
        /** @var int|null Optional. Number of Telegram Stars that can be claimed by the receiver by converting the gift; omitted if conversion to Telegram Stars is impossible */
        public null|int $convert_star_count = null,
        
        /** @var int|null Optional. Number of Telegram Stars that were prepaid by the sender for the ability to upgrade the gift */
        public null|int $prepaid_upgrade_star_count = null,
        
        /** @var bool|null Optional. True, if the gift can be upgraded to a unique gift */
        public null|bool $can_be_upgraded = null,
        
        /** @var string|null Optional. Text of the message that was added to the gift */
        public null|string $text = null,
        
        /** @var array<\MemoGram\Api\Types\MessageEntity>|null Optional. Special entities that appear in the text */
        public null|array $entities = null,
        
        /** @var bool|null Optional. True, if the sender and gift text are shown only to the gift receiver; otherwise, everyone will be able to see them */
        public null|bool $is_private = null,
        
        
    ) { }
}
