<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\PhotoSize;


class StickerSet
{
    use Concerns\Data;

    public function __construct(
        /** @var string Sticker set name */
        public string $name,
        
        /** @var string Sticker set title */
        public string $title,
        
        /** @var string Type of stickers in the set, currently one of “regular”, “mask”, “custom_emoji” */
        public string $sticker_type,
        
        /** @var array<\MemoGram\Api\Types\Sticker> List of all set stickers */
        public array $stickers,
        
        /** @var PhotoSize|null Optional. Sticker set thumbnail in the .WEBP, .TGS, or .WEBM format */
        public null|PhotoSize $thumbnail = null,
        
        
    ) { }
}
