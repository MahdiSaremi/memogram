<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class Gifts
{
    use Concerns\Data;

    public function __construct(
        /** @var array<\MemoGram\Api\Types\Gift> The list of gifts */
        public array $gifts,
        
        
    ) { }
}
