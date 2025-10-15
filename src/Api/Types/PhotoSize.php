<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PhotoSize
{
    use Concerns\Data;

    public function __construct(
        /** @var string Identifier for this file, which can be used to download or reuse the file */
        public string $file_id,
        
        /** @var string Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file. */
        public string $file_unique_id,
        
        /** @var int Photo width */
        public int $width,
        
        /** @var int Photo height */
        public int $height,
        
        /** @var int|null Optional. File size in bytes */
        public null|int $file_size = null,
        
        
    ) { }
}
