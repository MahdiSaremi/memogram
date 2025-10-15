<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class UniqueGiftBackdropColors
{
    use Concerns\Data;

    public function __construct(
        /** @var int The color in the center of the backdrop in RGB format */
        public int $center_color,
        
        /** @var int The color on the edges of the backdrop in RGB format */
        public int $edge_color,
        
        /** @var int The color to be applied to the symbol in RGB format */
        public int $symbol_color,
        
        /** @var int The color for the text on the backdrop in RGB format */
        public int $text_color,
        
        
    ) { }
}
