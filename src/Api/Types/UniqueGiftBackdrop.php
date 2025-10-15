<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\UniqueGiftBackdropColors;


class UniqueGiftBackdrop
{
    use Concerns\Data;

    public function __construct(
        /** @var string Name of the backdrop */
        public string $name,
        
        /** @var UniqueGiftBackdropColors Colors of the backdrop */
        public UniqueGiftBackdropColors $colors,
        
        /** @var int The number of unique gifts that receive this backdrop for every 1000 gifts upgraded */
        public int $rarity_per_mille,
        
        
    ) { }
}
