<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BotName
{
    use Concerns\Data;

    public function __construct(
        /** @var string The bot's name */
        public string $name,
        
        
    ) { }
}
