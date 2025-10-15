<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Document;


class BackgroundTypeWallpaper
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the background, always “wallpaper” */
        public string $type,
        
        /** @var Document Document with the wallpaper */
        public Document $document,
        
        /** @var int Dimming of the background in dark themes, as a percentage; 0-100 */
        public int $dark_theme_dimming,
        
        /** @var bool|null Optional. True, if the wallpaper is downscaled to fit in a 450x450 square and then box-blurred with radius 12 */
        public null|bool $is_blurred = null,
        
        /** @var bool|null Optional. True, if the background moves slightly when the device is tilted */
        public null|bool $is_moving = null,
        
        
    ) { }
}
