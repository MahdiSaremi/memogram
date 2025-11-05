<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class MessageOriginHiddenUser extends MessageOrigin
{
    use Concerns\Data;

    /** @var string Type of the message origin, always “hidden_user” */
    public string $type = 'hidden_user';

    public function __construct(
        /** @var int Date the message was sent originally in Unix time */
        public int $date,
        
        /** @var string Name of the user that sent the message originally */
        public string $sender_user_name,
        
        
    ) { }
}
