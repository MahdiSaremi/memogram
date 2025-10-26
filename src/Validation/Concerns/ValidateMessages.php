<?php

namespace MemoGram\Validation\Concerns;

use MemoGram\Api\Types\Message;
use MemoGram\Handle\Event;
use MemoGram\Support\MessageContent;

trait ValidateMessages
{
    protected null|int|float $validatedNumber = null;
    protected null|string $validatedText = null;

    protected function validateMessage(Event $event, $fail): ?Message
    {
        if (!$update = $this->validateUpdate($event, $fail)) {
            return null;
        }

        if ($update->message !== null) {
            return $update->message;
        }

        $fail('memogram::validation.be_message')->translate();
        return null;
    }

    protected function validateText(Event $event, $fail): bool
    {
        if (!$message = $this->validateMessage($event, $fail)) {
            return false;
        }

        if ($message->getType() == Message::TYPE_TEXT) {
            $this->validatedText = $message->text ?? "";
            return true;
        }

        $fail('memogram::validation.text')->translate();
        return false;
    }

    protected function validateMessageType(Event $event, $fail, string ...$types): void
    {
        if (!$message = $this->validateMessage($event, $fail)) {
            return;
        }

        if (!in_array($message->getType(), $types, true)) {
            $typeStr = array_reduce(array_keys($types), function (string $carry, int $i) use ($types) {
                $sep = match ($i) {
                    0 => '',
                    count($types) - 1 => __('memogram::generic.list_last_separator'),
                    default => __('memogram::generic.list_separator'),
                };

                return $carry . $sep . __('memogram::validation.message_types.' . $types[$i]);
            }, '');

            $fail('memogram::validation.message_type')->translate(['type' => $typeStr]);
        }
    }

    protected function validateContent(Event $event, $fail): void
    {
        if (!$message = $this->validateMessage($event, $fail)) {
            return;
        }

        if (!$message->isContent()) {
            $fail('memogram::validation.is_content')->translate();
        }

        $this->validatedText = $message->caption ?? $message->text;
    }

    protected function validateParagraph(Event $event, $fail): bool
    {
        if (!isset($this->validatedText) && !$this->validateText($event, $fail)) {
            return false;
        }

        if (str_contains($this->validatedText, "\n")) {
            $fail('memogram::validation.paragraph')->translate();
            return false;
        }

        return true;
    }

    protected function validateShortText(Event $event, $fail, int $max = 255): bool
    {
        if (!isset($this->validatedText) && !$this->validateText($event, $fail)) {
            return false;
        }

        if (strlen($this->validatedText) > $max) {
            $fail('memogram::validation.short_text_max_reached')->translate(['max' => $max]);
            return false;
        }

        return true;
    }

    protected function validateUnsignedNumber(Event $event, $fail): bool
    {
        if (!isset($this->validatedText) && !$this->validateText($event, $fail)) {
            return false;
        }

        if (!is_numeric($this->validatedText) || +$this->validatedText < 0) {
            $fail('memogram::validation.unsigned_number')->translate();
            return false;
        }

        $this->validatedNumber = +$this->validatedText;
        return true;
    }

    protected function validateNumber(Event $event, $fail): bool
    {
        if (!isset($this->validatedText) && !$this->validateText($event, $fail)) {
            return false;
        }

        if (!is_numeric($this->validatedText)) {
            $fail('memogram::validation.number')->translate();
            return false;
        }

        $this->validatedNumber = +$this->validatedText;
        return true;
    }

    protected function validateUnsignedInteger(Event $event, $fail): bool
    {
        if (!isset($this->validatedText) && !$this->validateText($event, $fail)) {
            return false;
        }

        if (!is_numeric($this->validatedText) || str_contains($this->validatedText, 'e') || str_contains($this->validatedText, 'E') || str_contains($this->validatedText, '.') || +$this->validatedText < 0) {
            $fail('memogram::validation.unsigned_int')->translate();
            return false;
        }

        $this->validatedNumber = (int)+$this->validatedText;
        return true;
    }

    protected function validateInteger(Event $event, $fail): bool
    {
        if (!isset($this->validatedText) && !$this->validateText($event, $fail)) {
            return false;
        }

        if (!is_numeric($this->validatedText) || str_contains($this->validatedText, 'e') || str_contains($this->validatedText, 'E') || str_contains($this->validatedText, '.')) {
            $fail('memogram::validation.int')->translate();
            return false;
        }

        $this->validatedNumber = (int)+$this->validatedText;
        return true;
    }

    protected function validateMin(Event $event, $fail, int $min): void
    {
        if (isset($this->validatedNumber)) {
            if ($this->validatedNumber < $min) {
                $fail('memogram::validation.min_number')->translate(['min' => $min]);
            }
        } elseif (isset($this->validatedText)) {
            if (strlen($this->validatedText) < $min) {
                $fail('memogram::validation.min_length')->translate(['min' => $min]);
            }
        } else {
            throw new \Exception("Min validation should be run for number or text only."); // todo
        }
    }

    protected function validateMax(Event $event, $fail, int $max): void
    {
        if (isset($this->validatedNumber)) {
            if ($this->validatedNumber < $max) {
                $fail('memogram::validation.max_number')->translate(['max' => $max]);
            }
        } elseif (isset($this->validatedText)) {
            if (strlen($this->validatedText) < $max) {
                $fail('memogram::validation.max_length')->translate(['max' => $max]);
            }
        } else {
            throw new \Exception("Max validation should be run for number or text only."); // todo
        }
    }
}