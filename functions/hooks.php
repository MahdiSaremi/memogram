<?php

namespace MemoGram\Hooks;

use Closure;
use MemoGram\Exceptions\ForcePageResponse;
use MemoGram\Handle\State;
use MemoGram\Matching\ListenerMatcher;
use MemoGram\Matching\Listeners\OnAny;
use MemoGram\Matching\Listeners\OnMessage;
use MemoGram\Response\GlassKey;
use MemoGram\Response\GlassMessageResponse;
use MemoGram\Response\Key;
use MemoGram\Response\MessageResponse;
use function MemoGram\Handle\page;

function useState($defaultValue): State
{
    return page()->useState($defaultValue);
}

function useWatch(Closure $callback, array $dependencyList)
{
    return page()->useWatch($callback, $dependencyList);
}

function useRefresh(array $dependencyList): bool
{
    return useWatch(function () {
        refresh();
        return true;
    }, $dependencyList) ?? false;
}

function useVersion($version, $fail = null): void
{
    page()->useVersion($version, $fail);
}

function useParam(string $name): State
{
    return useState(fn() => getParam($name));
}

function refresh(): void
{
    page()->refresh();
}

function getParam(string $name, $default = null)
{
    return page()->getParam($name, $default);
}

function getParams(): array
{
    return page()->getParams();
}

function open(string|array $reference, array $params = []): void
{
    $page = new \MemoGram\Handle\Page($reference);
    $page->mount($params);
}

function messageResponse($message = null): MessageResponse
{
    return (new MessageResponse)->when($message !== null)->message($message);
}

function glassMessageResponse($message = null): GlassMessageResponse
{
    return (new GlassMessageResponse)->when($message !== null)->message($message);
}

function key(string $text): Key
{
    return new Key($text);
}

function glassKey(string $text, ?string $id = null, ?string $url = null): GlassKey
{
    return new GlassKey($text, $id, $url);
}

function onAny(Closure $callback): OnAny
{
    return ListenerMatcher::$current->onAny(...func_get_args());
}

function onMessage(null|string|false|Closure $message = false, ?Closure $callback = null): OnMessage
{
    return ListenerMatcher::$current->onMessage(...func_get_args());
}
