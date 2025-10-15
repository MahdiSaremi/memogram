<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class VideoChatStarted
{
    use Concerns\Data;

    public function __construct(
        /** @var int Video chat duration in seconds */
        public int $duration,
        
        
    ) { }
}
