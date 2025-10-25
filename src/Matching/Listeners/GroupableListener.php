<?php

namespace MemoGram\Matching\Listeners;

use MemoGram\Matching\ListenerDispatcher;

interface GroupableListener
{
    public function getGroup(): ?ListenerDispatcher;

    public function prepareSubListener(Listener $listener): void;
}