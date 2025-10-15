<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PaidMessagePriceChanged
{
    use Concerns\Data;

    public function __construct(
        /** @var int The new number of Telegram Stars that must be paid by non-administrator users of the supergroup chat for each sent message */
        public int $paid_message_star_count,
        
        
    ) { }
}
