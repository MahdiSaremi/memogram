<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class MessageAutoDeleteTimerChanged
{
    use Concerns\Data;

    public function __construct(
        /** @var int New auto-delete time for messages in the chat; in seconds */
        public int $message_auto_delete_time,
        
        
    ) { }
}
