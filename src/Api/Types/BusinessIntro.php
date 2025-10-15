<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Sticker;


class BusinessIntro
{
    use Concerns\Data;

    public function __construct(
        /** @var string|null Optional. Title text of the business intro */
        public null|string $title = null,
        
        /** @var string|null Optional. Message text of the business intro */
        public null|string $message = null,
        
        /** @var Sticker|null Optional. Sticker of the business intro */
        public null|Sticker $sticker = null,
        
        
    ) { }
}
