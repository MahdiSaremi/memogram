<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BackgroundFillSolid
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the background fill, always “solid” */
        public string $type,
        
        /** @var int The color of the background fill in the RGB24 format */
        public int $color,
        
        
    ) { }
}
