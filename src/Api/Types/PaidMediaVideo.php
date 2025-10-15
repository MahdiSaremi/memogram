<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Video;


class PaidMediaVideo
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the paid media, always “video” */
        public string $type,
        
        /** @var Video The video */
        public Video $video,
        
        
    ) { }
}
