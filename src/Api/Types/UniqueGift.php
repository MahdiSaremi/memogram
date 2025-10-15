<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\UniqueGiftModel;
use MemoGram\Api\Types\UniqueGiftSymbol;
use MemoGram\Api\Types\UniqueGiftBackdrop;
use MemoGram\Api\Types\Chat;


class UniqueGift
{
    use Concerns\Data;

    public function __construct(
        /** @var string Human-readable name of the regular gift from which this unique gift was upgraded */
        public string $base_name,
        
        /** @var string Unique name of the gift. This name can be used in https://t.me/nft/... links and story areas */
        public string $name,
        
        /** @var int Unique number of the upgraded gift among gifts upgraded from the same regular gift */
        public int $number,
        
        /** @var UniqueGiftModel Model of the gift */
        public UniqueGiftModel $model,
        
        /** @var UniqueGiftSymbol Symbol of the gift */
        public UniqueGiftSymbol $symbol,
        
        /** @var UniqueGiftBackdrop Backdrop of the gift */
        public UniqueGiftBackdrop $backdrop,
        
        /** @var Chat|null Optional. Information about the chat that published the gift */
        public null|Chat $publisher_chat = null,
        
        
    ) { }
}
