<?php

namespace MemoGram\Validation;

use Closure;
use MemoGram\Handle\Event;

interface ValidationRule
{
    public function validate(Event $event, Closure $fail): void;
}