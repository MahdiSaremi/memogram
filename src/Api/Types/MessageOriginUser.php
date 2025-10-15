<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class MessageOriginUser
{
    use Concerns\Data;

    public function __construct(
        /** @var string Type of the message origin, always “user” */
        public string $type,
        
        /** @var int Date the message was sent originally in Unix time */
        public int $date,
        
        /** @var User User that sent the message originally */
        public User $sender_user,
        
        
    ) { }
}
