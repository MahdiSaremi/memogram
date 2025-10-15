<?php

namespace MemoGram\Handle\Trigger;

use MemoGram\Api\Types\Update;
use MemoGram\Handle\Event;

class OnUpdateTrigger extends EventTrigger
{
    public function check(Event $event): bool
    {
        if (!($event instanceof Update)) {
            return false;
        }
    }
}