<?php

namespace MemoGram\Matching\Listeners;

use Closure;
use Illuminate\Support\Traits\Conditionable;
use MemoGram\Handle\Event;
use MemoGram\Matching\MatchHelper;
use MemoGram\Validation\Validation;
use MemoGram\Validation\Validator;
use function MemoGram\Handle\context;

abstract class BaseListener implements Listener
{
    use Conditionable;

    public bool $atFirst = false;
    protected ?Closure $then = null;
    /** @var Validator[] */
    protected array $validators = [];

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
            context()->handler->runAction($this->then);
        }
    }
}