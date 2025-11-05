<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PaidMediaPhoto extends PaidMedia
{
    use Concerns\Data;

    /** @var string Type of the paid media, always “photo” */
    public string $type = 'photo';

    public function __construct(
        /** @var array<\MemoGram\Api\Types\PhotoSize> The photo */
        public array $photo,
        
        
    ) { }
}
