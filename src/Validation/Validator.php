<?php

namespace MemoGram\Validation;

use Closure;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Translation\PotentiallyTranslatedString;
use MemoGram\Exceptions\ValidationException;
use MemoGram\Handle\Event;

class Validator
{
    protected array $rules = [[]];
    protected array $errors;

    public function __construct(
        protected Event $event,
    )
    {
    }

    public function or()
    {
        $this->rules[] = [];
        return $this;
    }

    public function validate(): void
    {
        if (!$this->passes()) {
            throw new ValidationException($this->errors);
        }
    }

    public function passes(): bool
    {
        if (isset($this->errors)) {
            return empty($this->errors);
        }

        $this->errors = [];
        $lastError = null;
        $fail = static function (string $message) use (&$lastError) {
            return $lastError = new PotentiallyTranslatedString($message, app(Translator::class));
        };

        foreach ($this->rules as $ruleList) {
            foreach ($ruleList as $rule) {
                if ($this->callRule($rule, $fail)) {

                }
            }
        }
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function errors(): array
    {
        return $this->errors;
    }

    protected function callRule(mixed $rule, Closure $fail): bool
    {
        if (is_string($rule)) {
            if (class_exists($rule)) {
                $rule->validate($this->event, $fail);
            } else {

            }
        }
    }
}