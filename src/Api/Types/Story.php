<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;
use MemoGram\Api\Types\Chat;


class Story
{
    use Concerns\Data;

    public function __construct(
        /** @var Chat Chat that posted the story */
        public Chat $chat,
        
        /** @var int Unique identifier for the story in the chat */
        public int $id,
        
        
    ) { }
}
