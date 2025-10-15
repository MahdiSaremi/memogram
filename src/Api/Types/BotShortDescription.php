<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class BotShortDescription
{
    use Concerns\Data;

    public function __construct(
        /** @var string The bot's short description */
        public string $short_description,
        
        
    ) { }
}
