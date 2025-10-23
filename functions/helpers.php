<?php

namespace MemoGram\Handle {

    use MemoGram\Api\TelegramApi;
    use MemoGram\Api\Types\Update;

    function context(): ?Context
    {
        return EventHandler::$current;
    }

    function event(): ?Event
    {
        return context()?->event;
    }

    function getEvent(): ?Event
    {
        return context()?->event;
    }

    function eventHandler(): ?EventHandler
    {
        return context()?->handler;
    }

    function api(): ?TelegramApi
    {
        return context()->handler->api;
    }

    function update(): ?Update
    {
        if (($event = event()) instanceof Update) {
            return $event;
        }

        return null;
    }

    function page(): ?Page
    {
        if ($pageStack = context()?->handler->pageStack) {
            return end($pageStack);
        }

        return null;
    }
}
