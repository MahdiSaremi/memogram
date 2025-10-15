<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class StoryAreaPosition
{
    use Concerns\Data;

    public function __construct(
        /** @var float The abscissa of the area's center, as a percentage of the media width */
        public float $x_percentage,
        
        /** @var float The ordinate of the area's center, as a percentage of the media height */
        public float $y_percentage,
        
        /** @var float The width of the area's rectangle, as a percentage of the media width */
        public float $width_percentage,
        
        /** @var float The height of the area's rectangle, as a percentage of the media height */
        public float $height_percentage,
        
        /** @var float The clockwise rotation angle of the rectangle, in degrees; 0-360 */
        public float $rotation_angle,
        
        /** @var float The radius of the rectangle corner rounding, as a percentage of the media width */
        public float $corner_radius_percentage,
        
        
    ) { }
}
