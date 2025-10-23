<?php

namespace MemoGram\Validation\Concerns;

use MemoGram\Api\Types\Message;
use MemoGram\Handle\Event;

trait ValidateMessages
{
    protected null|int|float $validatedNumber = null;
    protected null|string $validatedText = null;

    protected function validateMessage(Event $event, $fail): ?Message
    {
        if (!$update = $this->validateUpdate($event, $fail)) {
            return null;
        }

        if ($update->message) {
            return $update->message;
        }

        $fail('memogram::validation.be_message')->translate();
        return null;
    }

    protected function validateText(Event $event, $fail): ?string
    {
        if (!$message = $this->validateMessage($event, $fail)) {
            return null;
        }

        if ($message->getType() == Message::TYPE_TEXT) {
            $this->validatedText = $message->text ?? "";
            return $message->text ?? "";
        }

        $fail('memogram::validation.text')->translate();
        return null;
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

    protected function validateParagraph(Event $event, $fail): ?string
    {
        if (null === $text = $this->validateText($event, $fail)) {
            return null;
        }

        if (str_contains($text, "\n")) {
            $fail('memogram::validation.paragraph')->translate();
            return null;
        }

        return $text;
    }

    protected function validateShortText(Event $event, $fail, int $max = 255): ?string
    {
        if (null === $text = $this->validateParagraph($event, $fail)) {
            return null;
        }

        if (strlen($text) > $max) {
            $fail('memogram::validation.short_text_max_reached')->translate(['max' => $max]);
            return null;
        }

        return $text;
    }

    protected function validateUnsignedNumber(Event $event, $fail): void
    {
        if (null === $text = $this->validateText($event, $fail)) {
            return;
        }

        if (!is_numeric($text) || +$text < 0) {
            $fail('memogram::validation.unsigned_number')->translate();
            return;
        }

        $this->validatedNumber = +$text;
    }

    protected function validateNumber(Event $event, $fail): void
    {
        if (null === $text = $this->validateText($event, $fail)) {
            return;
        }

        if (!is_numeric($text)) {
            $fail('memogram::validation.number')->translate();
            return;
        }

        $this->validatedNumber = +$text;
    }

    protected function validateUnsignedInt(Event $event, $fail): void
    {
        if (null === $text = $this->validateText($event, $fail)) {
            return;
        }

        if (!is_numeric($text) || str_contains($text, 'e') || str_contains($text, 'E') || str_contains($text, '.') || +$text < 0) {
            $fail('memogram::validation.unsigned_int')->translate();
            return;
        }

        $this->validatedNumber = (int)+$text;
    }

    protected function validateInt(Event $event, $fail): void
    {
        if (null === $text = $this->validateText($event, $fail)) {
            return;
        }

        if (!is_numeric($text) || str_contains($text, 'e') || str_contains($text, 'E') || str_contains($text, '.')) {
            $fail('memogram::validation.int')->translate();
            return;
        }

        $this->validatedNumber = (int)+$text;
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