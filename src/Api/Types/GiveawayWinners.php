<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;


class GiveawayWinners
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat The chat that created the giveaway */
        public Chat $chat,
        
        /** @var int Identifier of the message with the giveaway in the chat */
        public int $giveaway_message_id,
        
        /** @var int Point in time (Unix timestamp) when winners of the giveaway were selected */
        public int $winners_selection_date,
        
        /** @var int Total number of winners in the giveaway */
        public int $winner_count,
        
        /** @var array<\MemoGram\Api\Types\User> List of up to 100 winners of the giveaway */
        public array $winners,
        
        /** @var int|null Optional. The number of other chats the user had to join in order to be eligible for the giveaway */
        public null|int $additional_chat_count = null,
        
        /** @var int|null Optional. The number of Telegram Stars that were split between giveaway winners; for Telegram Star giveaways only */
        public null|int $prize_star_count = null,
        
        /** @var int|null Optional. The number of months the Telegram Premium subscription won from the giveaway will be active for; for Telegram Premium giveaways only */
        public null|int $premium_subscription_month_count = null,
        
        /** @var int|null Optional. Number of undistributed prizes */
        public null|int $unclaimed_prize_count = null,
        
        /** @var bool|null Optional. True, if only users who had joined the chats after the giveaway started were eligible to win */
        public null|bool $only_new_members = null,
        
        /** @var bool|null Optional. True, if the giveaway was canceled because the payment for it was refunded */
        public null|bool $was_refunded = null,
        
        /** @var string|null Optional. Description of additional giveaway prize */
        public null|string $prize_description = null,
        
        
    ) { }
}
