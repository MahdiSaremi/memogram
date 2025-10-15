<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BotCommandScopeAllChatAdministrators
{
    use Concerns\Data;

    public function __construct(
        /** @var string Scope type, must be all_chat_administrators */
        public string $type,
        
        
    ) { }
}
