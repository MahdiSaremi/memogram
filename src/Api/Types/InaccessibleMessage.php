<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;


class InaccessibleMessage
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat Chat the message belonged to */
        public Chat $chat,
        
        /** @var int Unique message identifier inside the chat */
        public int $message_id,
        
        /** @var int Always 0. The field can be used to differentiate regular and inaccessible messages. */
        public int $date,
        
        
    ) { }
}
