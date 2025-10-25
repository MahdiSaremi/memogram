<?php

namespace MemoGram\Matching;

use Closure;
use MemoGram\Handle\Event;
use MemoGram\Matching\Listeners\BaseListener;
use MemoGram\Matching\Listeners\GroupableListener;
use MemoGram\Matching\Listeners\Listener;
use MemoGram\Matching\Listeners\RouteGroup;
use MemoGram\Matching\Listeners\OnAny;
use MemoGram\Matching\Listeners\OnGlassKey;
use MemoGram\Matching\Listeners\OnKey;
use MemoGram\Matching\Listeners\OnMessage;
use MemoGram\Response\GlassKey;
use MemoGram\Response\Key;

class ListenerDispatcher
{
    public static ?ListenerDispatcher $current = null;
    public static bool $continue = false;

    /**
     * @var Listener[]
     */
    public array $listeners = [];

    public function __construct(
        protected ?GroupableListener $parent = null,
    )
    {
    }

    public function listen(Listener $listener): void
    {
        $this->parent?->prepareSubListener($listener);
        $this->listeners[] = $listener;
    }

    public function onAny(Closure $callback): OnAny
    {
        $this->listen($listener = new OnAny($callback));

        return $listener;
    }

    public function onMessage(null|string|false|Closure $message = false, ?Closure $callback = null): OnMessage
    {
        if ($message instanceof Closure) {
            $callback = $message;
            $message = false;
        }

        $this->listen($listener = (new OnMessage)->message($message)->when(isset($callback))->then($callback));

        return $listener;
    }

    public function onKey(Key $key): OnKey
    {
        $this->listen($listener = new OnKey($key));

        return $listener;
    }

    public function onGlassKey(GlassKey $key): OnGlassKey
    {
        $this->listen($listener = new OnGlassKey($key));

        return $listener;
    }

    public function withMiddleware($middleware): RouteGroup
    {
        $this->listen($listener = (new RouteGroup)->middleware($middleware));

        return $listener;
    }

    public function withPass($rule): RouteGroup
    {
        $this->listen($listener = (new RouteGroup)->pass($rule));

        return $listener;
    }

    public function changeAsCurrent(\Closure $callback): void
    {
        $old = static::$current;

        try {
            static::$current = $this;
            $callback();
        } finally {
            static::$current = $old;
        }
    }

    public static function continue(): void
    {
        static::$continue = true;
    }

    public function pushEventAt(Event $event, bool $atFirst): bool
    {
        $helper = new MatchHelper();

        foreach ($this->listeners as $listener) {
            $group = $listener instanceof GroupableListener ? $listener->getGroup() : null;

            if (!$group && $atFirst != @$listener->atFirst ?? false) {
                continue;
            }

            if ($listener->runCheck($event, $helper)) {
                if ($group) {
                    if ($group->pushEventAt($event, $atFirst)) {
                        return true;
                    }
                } else {
                    $old = static::$continue;

                    try {
                        static::$continue = false;

                        $listener->runAction($event);

                        if (!static::$continue) {
                            return true;
                        }
                    } finally {
                        static::$continue = $old;
                    }
                }
            }
        }

        return false;
    }

    public function pushEvent(Event $event): bool
    {
        if ($this->pushEventAt($event, true)) {
            return true;
        }

        if ($this->pushEventAt($event, false)) {
            return true;
        }

        return false;
    }

    public function pushEventAsPipe(Event $event, Closure $next): bool
    {
        if ($this->pushEventAt($event, true)) {
            return true;
        }

        if ($next($event)) {
            return true;
        }

        if ($this->pushEventAt($event, false)) {
            return true;
        }

        return false;
    }
}