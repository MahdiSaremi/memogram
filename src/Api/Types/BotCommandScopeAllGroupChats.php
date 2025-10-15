<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BotCommandScopeAllGroupChats
{
    use Concerns\Data;

    public function __construct(
        /** @var string Scope type, must be all_group_chats */
        public string $type,
        
        
    ) { }
}
