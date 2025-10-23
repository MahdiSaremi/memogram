<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Handle\Event;
use MemoGram\Matching\MatchHelper;

interface Listener
{
    public function runCheck(Event $event, MatchHelper $match): bool;

    public function runAction(Event $event): void;
}