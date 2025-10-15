<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PaidMediaPhoto
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the paid media, always “photo” */
        public string $type,
        
        /** @var array<\MemoGram\Api\Types\PhotoSize> The photo */
        public array $photo,
        
        
    ) { }
}
