<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BotCommandScopeChat
{
    use Concerns\Data;

    public function __construct(
        /** @var string Scope type, must be chat */
        public string $type,
        
        /** @var int|string Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername). Channel direct messages chats and channel chats aren't supported. */
        public int $chat_id,
        
        
    ) { }
}
