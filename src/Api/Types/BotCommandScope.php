<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BotCommandScope
{
    use Concerns\Data;

    public function __construct(
        /** @var string Scope type, must be default */
        public string $type,
        
        
    ) { }
}
