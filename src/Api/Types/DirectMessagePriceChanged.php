<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class DirectMessagePriceChanged
{
    use Concerns\Data;

    public function __construct(
        /** @var bool True, if direct messages are enabled for the channel chat; false otherwise */
        public bool $are_direct_messages_enabled,
        
        /** @var int|null Optional. The new number of Telegram Stars that must be paid by users for each direct message sent to the channel. Does not apply to users who have been exempted by administrators. Defaults to 0. */
        public null|int $direct_message_star_count = null,
        
        
    ) { }
}
