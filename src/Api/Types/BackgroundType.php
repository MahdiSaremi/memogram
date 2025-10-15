<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\BackgroundFill;


class BackgroundType
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the background, always “fill” */
        public string $type,
        
        /** @var BackgroundFill The background fill */
        public BackgroundFill $fill,
        
        /** @var int Dimming of the background in dark themes, as a percentage; 0-100 */
        public int $dark_theme_dimming,
        
        
    ) { }
}
