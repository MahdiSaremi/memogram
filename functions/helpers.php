<?php

namespace MemoGram\Handle {

    use MemoGram\Api\Types\Update;

    function context(): ?Context
    {
        return EventHandler::$current;
    }

    function event(): ?Event
    {
        return context()?->event;
    }

    function update(): ?Update
    {
        if (($event = event()) instanceof Update) {
            return $event;
        }

        return null;
    }
}
