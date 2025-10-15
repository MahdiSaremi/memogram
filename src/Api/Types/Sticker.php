<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\PhotoSize;
use MemoGram\Api\Types\File;
use MemoGram\Api\Types\MaskPosition;


class Sticker
{
    use Concerns\Data;

    public function __construct(
        /** @var string Identifier for this file, which can be used to download or reuse the file */
        public string $file_id,
        
        /** @var string Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file. */
        public string $file_unique_id,
        
        /** @var string Type of the sticker, currently one of “regular”, “mask”, “custom_emoji”. The type of the sticker is independent from its format, which is determined by the fields is_animated and is_video. */
        public string $type,
        
        /** @var int Sticker width */
        public int $width,
        
        /** @var int Sticker height */
        public int $height,
        
        /** @var bool True, if the sticker is animated */
        public bool $is_animated,
        
        /** @var bool True, if the sticker is a video sticker */
        public bool $is_video,
        
        /** @var PhotoSize|null Optional. Sticker thumbnail in the .WEBP or .JPG format */
        public null|PhotoSize $thumbnail = null,
        
        /** @var string|null Optional. Emoji associated with the sticker */
        public null|string $emoji = null,
        
        /** @var string|null Optional. Name of the sticker set to which the sticker belongs */
        public null|string $set_name = null,
        
        /** @var File|null Optional. For premium regular stickers, premium animation for the sticker */
        public null|File $premium_animation = null,
        
        /** @var MaskPosition|null Optional. For mask stickers, the position where the mask should be placed */
        public null|MaskPosition $mask_position = null,
        
        /** @var string|null Optional. For custom emoji stickers, unique identifier of the custom emoji */
        public null|string $custom_emoji_id = null,
        
        /** @var bool|null Optional. True, if the sticker must be repainted to a text color in messages, the color of the Telegram Premium badge in emoji status, white color on chat photos, or another appropriate color in other places */
        public null|bool $needs_repainting = null,
        
        /** @var int|null Optional. File size in bytes */
        public null|int $file_size = null,
        
        
    ) { }
}
