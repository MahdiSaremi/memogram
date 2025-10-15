<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\User;


class DirectMessagesTopic
{
    use Concerns\Data;

    public function __construct(
        /** @var int Unique identifier of the topic. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier. */
        public int $topic_id,
        
        /** @var User|null Optional. Information about the user that created the topic. Currently, it is always present */
        public null|User $user = null,
        
        
    ) { }
}
