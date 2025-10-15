<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Giveaway
{
    use Concerns\Data;

    public function __construct(
        /** @var array<\MemoGram\Api\Types\Chat> The list of chats which the user must join to participate in the giveaway */
        public array $chats,
        
        /** @var int Point in time (Unix timestamp) when winners of the giveaway will be selected */
        public int $winners_selection_date,
        
        /** @var int The number of users which are supposed to be selected as winners of the giveaway */
        public int $winner_count,
        
        /** @var bool|null Optional. True, if only users who join the chats after the giveaway started should be eligible to win */
        public null|bool $only_new_members = null,
        
        /** @var bool|null Optional. True, if the list of giveaway winners will be visible to everyone */
        public null|bool $has_public_winners = null,
        
        /** @var string|null Optional. Description of additional giveaway prize */
        public null|string $prize_description = null,
        
        /** @var array<\MemoGram\Api\Types\string>|null Optional. A list of two-letter ISO 3166-1 alpha-2 country codes indicating the countries from which eligible users for the giveaway must come. If empty, then all users can participate in the giveaway. Users with a phone number that was bought on Fragment can always participate in giveaways. */
        public null|array $country_codes = null,
        
        /** @var int|null Optional. The number of Telegram Stars to be split between giveaway winners; for Telegram Star giveaways only */
        public null|int $prize_star_count = null,
        
        /** @var int|null Optional. The number of months the Telegram Premium subscription won from the giveaway will be active for; for Telegram Premium giveaways only */
        public null|int $premium_subscription_month_count = null,
        
        
    ) { }
}
