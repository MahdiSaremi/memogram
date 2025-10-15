<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\Gift;


class TransactionPartnerChat
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the transaction partner, always “chat” */
        public string $type,
        
        /** @var Chat Information about the chat */
        public Chat $chat,
        
        /** @var Gift|null Optional. The gift sent to the chat by the bot */
        public null|Gift $gift = null,
        
        
    ) { }
}
