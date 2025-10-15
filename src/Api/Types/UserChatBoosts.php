<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class UserChatBoosts
{
    use Concerns\Data;

    public function __construct(
        /** @var array<\MemoGram\Api\Types\ChatBoost> The list of boosts added to the chat by the user */
        public array $boosts,
        
        
    ) { }
}
