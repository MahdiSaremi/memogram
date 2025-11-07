<?php

namespace MemoGram\Handle;

use Closure;
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

function pushEvent(Event $event): void
{
    eventHandler()->handle($event);
}

function handleAs(TelegramApi|EventHandler $api, Closure $callback): void
{
    if ($api instanceof TelegramApi) {
        $api = new EventHandler($api);
    }

    $api->useContext($callback);
}

function areaRegistry(): AreaRegistry
{
    return eventHandler()->areaRegistry();
}
