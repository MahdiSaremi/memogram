<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Handle\Event;
use MemoGram\Matching\MatcherHelper;

interface Listener
{
    public function runCheck(Event $event, MatcherHelper $match): bool;

    public function runAction(Event $event): void;
}