<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Video;


class PaidMediaVideo extends PaidMedia
{
    use Concerns\Data;

    /** @var string Type of the paid media, always “video” */
    public string $type = 'video';

    public function __construct(
        /** @var Video The video */
        public Video $video,
        
        
    ) { }
}
