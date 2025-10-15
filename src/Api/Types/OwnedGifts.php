<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class OwnedGifts
{
    use Concerns\Data;

    public function __construct(
        /** @var int The total number of gifts owned by the user or the chat */
        public int $total_count,
        
        /** @var array<\MemoGram\Api\Types\OwnedGift> The list of gifts */
        public array $gifts,
        
        /** @var string|null Optional. Offset for the next request. If empty, then there are no more results */
        public null|string $next_offset = null,
        
        
    ) { }
}
