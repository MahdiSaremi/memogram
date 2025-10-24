<?php

namespace MemoGram\Validation;

use MemoGram\Handle\Event;
use function MemoGram\Handle\getEvent;

class Validation
{
    public static function make($rule = [], $messages = [], ?Event $event = null): Validator
    {
        return (new Validator($event ?? getEvent()))->add($rule, $messages);
    }

    public static function validate($rule, $messages = [], ?Event $event = null): void
    {
        static::make($rule, $messages, $event)->validate();
    }
}