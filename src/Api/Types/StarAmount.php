<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class StarAmount
{
    use Concerns\Data;

    public function __construct(
        /** @var int Integer amount of Telegram Stars, rounded to 0; can be negative */
        public int $amount,
        
        /** @var int|null Optional. The number of 1/1000000000 shares of Telegram Stars; from -999999999 to 999999999; can be negative if and only if amount is non-positive */
        public null|int $nanostar_amount = null,
        
        
    ) { }
}
