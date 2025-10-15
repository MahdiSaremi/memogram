<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class TransactionPartnerAffiliateProgram
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the transaction partner, always “affiliate_program” */
        public string $type,
        
        /** @var User|null Optional. Information about the bot that sponsored the affiliate program */
        public null|User $sponsor_user = null,
        
        /** @var int The number of Telegram Stars received by the bot for each 1000 Telegram Stars received by the affiliate program sponsor from referred users */
        public int $commission_per_mille,
        
        
    ) { }
}
