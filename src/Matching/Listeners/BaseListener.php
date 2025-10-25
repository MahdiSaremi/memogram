<?php

namespace MemoGram\Matching\Listeners;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Conditionable;
use MemoGram\Handle\Event;
use MemoGram\Matching\ListenerDispatcher;
use MemoGram\Matching\MatchHelper;
use MemoGram\Validation\Validation;
use MemoGram\Validation\Validator;
use function MemoGram\Handle\eventHandler;

abstract class BaseListener implements Listener, GroupableListener
{
    use Conditionable;

    public ?bool $atFirst = null;
    protected ?Closure $then = null;
    /** @var Validator[] */
    protected array $validators = [];
    protected array $middlewares = [];
    protected ?ListenerDispatcher $group = null;

    public function atFirst()
    {
        $this->atFirst = true;
        return $this;
    }

    public function atLast()
    {
        $this->atFirst = false;
        return $this;
    }

    public function pass($rule)
    {
        if (!($rule instanceof Validator)) {
            $rule = Validation::make($rule);
        }

        $this->validators[] = $rule;
        return $this;
    }

    public function then(Closure $callback)
    {
        $this->then = $callback;
        return $this;
    }

    public function middleware($middleware)
    {
        array_push($this->middlewares, ...Arr::wrap($middleware));
        return $this;
    }

    public function withoutMiddleware($middleware)
    {
        $this->middlewares = array_filter($this->middlewares, function ($mid) use ($middleware) {
            return (is_object($mid) ? get_class($mid) : $mid) != $middleware;
        });

        return $this;
    }

    public function group(Closure $callback)
    {
        $this->group ??= new ListenerDispatcher($this);
        $this->group->changeAsCurrent($callback);

        return $this;
    }

    public function runCheck(Event $event, MatchHelper $match): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->copyForEvent($event)->passes()) {
                return false;
            }
        }

        return true;
    }

    public function runAction(Event $event): void
    {
        if ($this->then) {
            eventHandler()->runAction(
                eventHandler()->createMiddlewarePipeline($this->middlewares, $this->then, $this->getArguments()),
            );
        }
    }

    protected function getArguments(): array
    {
        return [];
    }

    public function getGroup(): ?ListenerDispatcher
    {
        return $this->group;
    }

    public function prepareSubListener(Listener $listener): void
    {
        if (method_exists($listener, 'middleware')) {
            $listener->middleware($this->middlewares);
        }

        if ($this->atFirst !== null) {
            if ($this->atFirst) {
                method_exists($listener, 'atFirst') && $listener->atFirst();
            } else {
                method_exists($listener, 'atLast') && $listener->atLast();
            }
        }
    }
}