<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\PhotoSize;


class VideoNote
{
    use Concerns\Data;

    public function __construct(
        /** @var string Identifier for this file, which can be used to download or reuse the file */
        public string $file_id,
        
        /** @var string Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file. */
        public string $file_unique_id,
        
        /** @var int Video width and height (diameter of the video message) as defined by the sender */
        public int $length,
        
        /** @var int Duration of the video in seconds as defined by the sender */
        public int $duration,
        
        /** @var PhotoSize|null Optional. Video thumbnail */
        public null|PhotoSize $thumbnail = null,
        
        /** @var int|null Optional. File size in bytes */
        public null|int $file_size = null,
        
        
    ) { }
}
