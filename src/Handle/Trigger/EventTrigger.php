<?php

namespace MemoGram\Handle\Trigger;

use MemoGram\Handle\Event;

class EventTrigger
{
    public function check(Event $event): bool
    {
        return false;
    }

    public function handle(Event $event): bool
    {

    }
}