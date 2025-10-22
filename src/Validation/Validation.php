<?php

namespace MemoGram\Validation;

use MemoGram\Handle\Event;
use function MemoGram\Handle\getEvent;

class Validation
{
    public function make(array $rules, ?Event $event = null): Validator
    {
        return (new Validator($event ?? getEvent()))->add($rules);
    }

    public function validate(array $rules, ?Event $event = null): void
    {
        $this->make($rules, $event)->validate();
    }
}