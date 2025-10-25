<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Handle\Event;
use MemoGram\Matching\MatchHelper;

class RouteGroup extends BaseListener
{
    public function runCheck(Event $event, MatchHelper $match): bool
    {
        return ($this->group || $this->then) && parent::runCheck($event, $match);
    }
}