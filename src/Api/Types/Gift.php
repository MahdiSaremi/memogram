<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Sticker;
use MemoGram\Api\Types\Chat;


class Gift
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique identifier of the gift */
        public string $id,
        
        /** @var Sticker The sticker that represents the gift */
        public Sticker $sticker,
        
        /** @var int The number of Telegram Stars that must be paid to send the sticker */
        public int $star_count,
        
        /** @var int|null Optional. The number of Telegram Stars that must be paid to upgrade the gift to a unique one */
        public null|int $upgrade_star_count = null,
        
        /** @var int|null Optional. The total number of the gifts of this type that can be sent; for limited gifts only */
        public null|int $total_count = null,
        
        /** @var int|null Optional. The number of remaining gifts of this type that can be sent; for limited gifts only */
        public null|int $remaining_count = null,
        
        /** @var Chat|null Optional. Information about the chat that published the gift */
        public null|Chat $publisher_chat = null,
        
        
    ) { }
}
