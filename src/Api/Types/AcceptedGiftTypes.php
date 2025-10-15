<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class AcceptedGiftTypes
{
    use Concerns\Data;

    public function __construct(
        /** @var bool True, if unlimited regular gifts are accepted */
        public bool $unlimited_gifts,
        
        /** @var bool True, if limited regular gifts are accepted */
        public bool $limited_gifts,
        
        /** @var bool True, if unique gifts or gifts that can be upgraded to unique for free are accepted */
        public bool $unique_gifts,
        
        /** @var bool True, if a Telegram Premium subscription is accepted */
        public bool $premium_subscription,
        
        
    ) { }
}
