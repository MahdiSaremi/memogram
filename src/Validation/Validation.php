<?php

namespace MemoGram\Validation;

use MemoGram\Handle\Event;
use function MemoGram\Handle\getEvent;

class Validation
{
    public static function make($rule = [], ?Event $event = null): Validator
    {
        return (new Validator($event ?? getEvent()))->add($rule);
    }

    public static function validate($rule, ?Event $event = null): void
    {
        static::make($rule, $event)->validate();
    }
}