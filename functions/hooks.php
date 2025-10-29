<?php

namespace MemoGram\Hooks;

use Closure;
use MemoGram\Exceptions\StopPage;
use MemoGram\Handle\Form\Form;
use MemoGram\Handle\GarbageState;
use MemoGram\Handle\State;
use MemoGram\Matching\ListenerDispatcher;
use MemoGram\Matching\Listeners\OnCommand;
use MemoGram\Matching\Listeners\RouteGroup;
use MemoGram\Matching\Listeners\OnAny;
use MemoGram\Matching\Listeners\OnMessage;
use MemoGram\Response\DeleteResponse;
use MemoGram\Response\GlassKey;
use MemoGram\Response\GlassMessageResponse;
use MemoGram\Response\Key;
use MemoGram\Response\MessageResponse;
use MemoGram\Response\TakeControl;
use function MemoGram\Handle\eventHandler;
use function MemoGram\Handle\page;

function useState($defaultValue): State
{
    return page()->useState($defaultValue);
}

function useGarbageState($defaultValue): GarbageState
{
    return page()->useGarbageState($defaultValue);
}

/**
 * @template T
 * @param $key
 * @param Closure(): T $callback
 * @return T
 */
function useDynamic($key, Closure $callback): mixed
{
    return page()->useDynamic($key, $callback);
}

/**
 * @template T
 * @template E
 * @param bool $condition
 * @param Closure(): T $then
 * @param null|Closure(): E $default
 * @return T|E
 */
function useIf(bool $condition, Closure $then, ?Closure $default = null): mixed
{
    return page()->useDynamic($condition, function () use ($default, $condition, $then) {
        return $condition ? $then() : value($default);
    });
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

function useForm(array $default = []): Form
{
    return Form::use($default);
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

function takeControl(): TakeControl
{
    return (new TakeControl);
}

function deleteResponse(?string $id = null): DeleteResponse
{
    return (new DeleteResponse)->when($id !== null)->id($id);
}

function key(string $text, $then = null): Key
{
    return (new Key($text))->when($then !== null)->then($then);
}

function glassKey(string $text, ?string $id = null, ?string $url = null): GlassKey
{
    return new GlassKey($text, $id, $url);
}

function mounting(): bool
{
    return page()->status == \MemoGram\Handle\Page::STATUS_MOUNTING;
}

function hydrating(): bool
{
    return page()->status == \MemoGram\Handle\Page::STATUS_HYDRATING;
}

function refreshing(): bool
{
    return page()->status == \MemoGram\Handle\Page::STATUS_REFRESHING;
}

function currentListener(): ListenerDispatcher
{
    return ListenerDispatcher::$current ?? page()->listener;
}

function stopPage(): StopPage
{
    return new StopPage();
}

function replaceResponse($response): void
{
    page()->replaceResponse($response);
}

function onAny($callback): OnAny
{
    return currentListener()->onAny(...func_get_args());
}

function onMessage(null|string|false|Closure $message = false, $callback = null): OnMessage
{
    return currentListener()->onMessage(...func_get_args());
}

function onCommand(string $command, $callback = null): OnCommand
{
    return currentListener()->onCommand(...func_get_args());
}

function withMiddleware($middleware): RouteGroup
{
    return currentListener()->withMiddleware($middleware);
}

function withPass($rule): RouteGroup
{
    return currentListener()->withPass($rule);
}

function withGlobalMiddleware($middleware): void
{
    eventHandler()->withGlobalMiddleware($middleware);
}
