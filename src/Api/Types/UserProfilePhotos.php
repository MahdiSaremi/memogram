<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class UserProfilePhotos
{
    use Concerns\Data;

    public function __construct(
        /** @var int Total number of profile pictures the target user has */
        public int $total_count,
        
        /** @var array<\MemoGram\Api\Types\array<\MemoGram\Api\Types\PhotoSize>> Requested profile pictures (in up to 4 sizes each) */
        public array $photos,
        
        
    ) { }
}
