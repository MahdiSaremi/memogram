<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class PaidMedia
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the paid media, always “preview” */
        public string $type,
        
        /** @var int|null Optional. Media width as defined by the sender */
        public null|int $width = null,
        
        /** @var int|null Optional. Media height as defined by the sender */
        public null|int $height = null,
        
        /** @var int|null Optional. Duration of the media in seconds as defined by the sender */
        public null|int $duration = null,
        
        
    ) { }
}
