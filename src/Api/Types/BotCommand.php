<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BotCommand
{
    use Concerns\Data;

    public function __construct(
        /** @var string Text of the command; 1-32 characters. Can contain only lowercase English letters, digits and underscores. */
        public string $command,
        
        /** @var string Description of the command; 1-256 characters. */
        public string $description,
        
        
    ) { }
}
