<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;
use MemoGram\Api\Types\User;


class PollAnswer
{
    use Concerns\Data;

    public function __construct(
        /** @var string Unique poll identifier */
        public string $poll_id,
        
        /** @var Chat|null Optional. The chat that changed the answer to the poll, if the voter is anonymous */
        public null|Chat $voter_chat = null,
        
        /** @var User|null Optional. The user that changed the answer to the poll, if the voter isn't anonymous */
        public null|User $user = null,
        
        /** @var array<\MemoGram\Api\Types\int> 0-based identifiers of chosen answer options. May be empty if the vote was retracted. */
        public array $option_ids,
        
        
    ) { }
}
