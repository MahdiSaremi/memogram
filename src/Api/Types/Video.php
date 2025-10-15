<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\PhotoSize;


class Video
{
    use Concerns\Data;

    public function __construct(
        /** @var string Identifier for this file, which can be used to download or reuse the file */
        public string $file_id,
        
        /** @var string Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file. */
        public string $file_unique_id,
        
        /** @var int Video width as defined by the sender */
        public int $width,
        
        /** @var int Video height as defined by the sender */
        public int $height,
        
        /** @var int Duration of the video in seconds as defined by the sender */
        public int $duration,
        
        /** @var PhotoSize|null Optional. Video thumbnail */
        public null|PhotoSize $thumbnail = null,
        
        /** @var array<\MemoGram\Api\Types\PhotoSize>|null Optional. Available sizes of the cover of the video in the message */
        public null|array $cover = null,
        
        /** @var int|null Optional. Timestamp in seconds from which the video will play in the message */
        public null|int $start_timestamp = null,
        
        /** @var string|null Optional. Original filename as defined by the sender */
        public null|string $file_name = null,
        
        /** @var string|null Optional. MIME type of the file as defined by the sender */
        public null|string $mime_type = null,
        
        /** @var int|null Optional. File size in bytes. It can be bigger than 2^31 and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this value. */
        public null|int $file_size = null,
        
        
    ) { }
}
