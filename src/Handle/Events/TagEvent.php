<?php

namespace MemoGram\Handle\Events;

use MemoGram\Handle\Event;

class TagEvent implements Event
{
    public function __construct(
        public string $tag,
    )
    {
    }
}