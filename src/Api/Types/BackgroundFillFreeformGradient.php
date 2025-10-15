<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BackgroundFillFreeformGradient
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the background fill, always “freeform_gradient” */
        public string $type,
        
        /** @var array<\MemoGram\Api\Types\int> A list of the 3 or 4 base colors that are used to generate the freeform gradient in the RGB24 format */
        public array $colors,
        
        
    ) { }
}
