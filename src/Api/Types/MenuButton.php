<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class MenuButton
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the button, must be commands */
        public string $type,
        
        
    ) { }
}
