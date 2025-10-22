<?php

namespace MemoGram\Validation\Rules;

use Closure;
use MemoGram\Handle\Event;
use MemoGram\Validation\ValidationRule;

class ClosureValidationRule implements ValidationRule
{
    public function __construct(
        protected $callback,
    )
    {
    }

    public function validate(Event $event, Closure $fail): void
    {
        $this->callback($event, $fail);
    }
}