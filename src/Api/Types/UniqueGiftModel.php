<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Sticker;


class UniqueGiftModel
{
    use Concerns\Data;

    public function __construct(
        /** @var string Name of the model */
        public string $name,
        
        /** @var Sticker The sticker that represents the unique gift */
        public Sticker $sticker,
        
        /** @var int The number of unique gifts that receive this model for every 1000 gifts upgraded */
        public int $rarity_per_mille,
        
        
    ) { }
}
