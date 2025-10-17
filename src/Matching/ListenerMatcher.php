<?php

namespace MemoGram\Matching;

use Closure;
use MemoGram\Handle\Event;
use MemoGram\Matching\Listeners\Listener;
use MemoGram\Matching\Listeners\OnAny;
use MemoGram\Matching\Listeners\OnGlassKey;
use MemoGram\Matching\Listeners\OnKey;
use MemoGram\Matching\Listeners\OnMessage;
use MemoGram\Response\GlassKey;
use MemoGram\Response\Key;

class ListenerMatcher
{
    public static ?ListenerMatcher $current = null;
    public static bool $continue = false;

    /**
     * @var Listener[]
     */
    public array $listeners = [];

    public function onAny(Closure $callback): OnAny
    {
        return $this->listeners[] = new OnAny($callback);
    }

    public function onMessage(null|string|false|Closure $message = false, ?Closure $callback = null): OnMessage
    {
        if ($message instanceof Closure) {
            $callback = $message;
            $message = false;
        }

        return $this->listeners[] = (new OnMessage)->message($message)->when(isset($callback))->then($callback);
    }

    public function onKey(Key $key): OnKey
    {
        return $this->listeners[] = new OnKey($key);
    }

    public function onGlassKey(GlassKey $key): OnGlassKey
    {
        return $this->listeners[] = new OnGlassKey($key);
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

    public function pushEventAt(Event $event, bool $atFirst): bool
    {
        $matcher = new MatcherHelper();

        foreach ($this->listeners as $listener) {
            if ($atFirst !== @$listener->atFirst ?? false) {
                continue;
            }

            if ($listener->runCheck($event, $matcher)) {
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