<?php

namespace MemoGram\Validation\Concerns;

use MemoGram\Api\Types\Update;
use MemoGram\Handle\Event;

trait ValidateUpdates
{
    protected function validateUpdate(Event $event, $fail): ?Update
    {
        if ($event instanceof Update) {
            return $event;
        }

        $fail('memogram::validation.be_update')->translate();
        return null;
    }
}