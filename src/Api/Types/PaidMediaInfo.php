<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PaidMediaInfo
{
    use Concerns\Data;

    public function __construct(
        /** @var int The number of Telegram Stars that must be paid to buy access to the media */
        public int $star_count,
        
        /** @var array<\MemoGram\Api\Types\PaidMedia> Information about the paid media */
        public array $paid_media,
        
        
    ) { }
}
