<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class MessageOriginHiddenUser
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the message origin, always “hidden_user” */
        public string $type,
        
        /** @var int Date the message was sent originally in Unix time */
        public int $date,
        
        /** @var string Name of the user that sent the message originally */
        public string $sender_user_name,
        
        
    ) { }
}
