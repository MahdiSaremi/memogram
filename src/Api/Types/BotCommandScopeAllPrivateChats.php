<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BotCommandScopeAllPrivateChats
{
    use Concerns\Data;

    public function __construct(
        /** @var string Scope type, must be all_private_chats */
        public string $type,
        
        
    ) { }
}
