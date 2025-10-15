<?php

declare(strict_types=1);

namespace MemoGram\Api\Types;

use MemoGram\Api\Concerns;


class VideoChatScheduled
{
    use Concerns\Data;

    public function __construct(
        /** @var int Point in time (Unix timestamp) when the video chat is supposed to be started by a chat administrator */
        public int $start_date,
        
        
    ) { }
}
