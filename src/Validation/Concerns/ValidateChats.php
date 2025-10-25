<?php

namespace MemoGram\Validation\Concerns;

use MemoGram\Handle\Event;

trait ValidateChats
{
    protected function validateChatType(Event $event, $fail, ...$types): void
    {
        if (!$message = $this->validateMessage($event, $fail)) {
            return;
        }

        if (!in_array($message->chat->type, $types, true)) {
            $typeStr = array_reduce(array_keys($types), function (string $carry, int $i) use ($types) {
                $sep = match ($i) {
                    0 => '',
                    count($types) - 1 => __('memogram::generic.list_last_separator'),
                    default => __('memogram::generic.list_separator'),
                };

                return $carry . $sep . __('memogram::validation.chat_types.' . $types[$i]);
            }, '');

            $fail('memogram::validation.chat_type')->translate(['type' => $typeStr]);
        }
    }
}