<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BackgroundFillGradient
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the background fill, always “gradient” */
        public string $type,
        
        /** @var int Top color of the gradient in the RGB24 format */
        public int $top_color,
        
        /** @var int Bottom color of the gradient in the RGB24 format */
        public int $bottom_color,
        
        /** @var int Clockwise rotation angle of the background fill in degrees; 0-359 */
        public int $rotation_angle,
        
        
    ) { }
}
