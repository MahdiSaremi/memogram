<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class UsersShared
{
    use Concerns\Data;

    public function __construct(
        /** @var int Identifier of the request */
        public int $request_id,
        
        /** @var array<\MemoGram\Api\Types\SharedUser> Information about users shared with the bot. */
        public array $users,
        
        
    ) { }
}
