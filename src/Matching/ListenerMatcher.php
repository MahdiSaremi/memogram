<?php

namespace MemoGram\Matching;

use Closure;
use MemoGram\Handle\Event;
use MemoGram\Matching\Listeners\Listener;
use MemoGram\Matching\Listeners\OnMessage;

class ListenerMatcher
{
    public static ?ListenerMatcher $current = null;
    public static bool $continue = false;

    /**
     * @var Listener[]
     */
    public array $listeners = [];

    public function onMessage(null|string|false|Closure $message = false, ?Closure $callback = null): OnMessage
    {
        if ($message instanceof Closure) {
            $callback = $message;
            $message = false;
        }

        return $this->listeners[] = (new OnMessage)->message($message)->when($callback)->then($callback);
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
        $this->pushEventAt($event, true);
        $this->pushEventAt($event, false);
    }
}