<?php

namespace MemoGram\Validation;

use Closure;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Translation\PotentiallyTranslatedString;
use MemoGram\Exceptions\ValidationException;
use MemoGram\Handle\Event;

class Validator
{
    use Concerns\ValidateUpdates,
        Concerns\ValidateMessages;

    protected array $rules = [[]];
    protected array $specificMessages = [[]];
    protected array $errors;

    public function __construct(
        protected ?Event $event,
    )
    {
    }

    public function or()
    {
        $this->rules[] = [];
        $this->specificMessages[] = [];
        return $this;
    }

    public function add($rule, $messages = [])
    {
        $rules = ValidationRuleParser::explode($rule);
        $finalMessages = array_fill(0, count($rules), null);

        if (!is_array($messages)) {
            $messages = array_fill(0, count($rules), $messages);
        }

        foreach ($messages as $for => $message) {
            if (is_string($for)) {
                foreach ($rules as $index => $rule) {
                    if ($rule === $for || (is_object($rule) && get_class($rule) === $for)) {
                        $for = $index;
                        break;
                    }
                }
            }

            if (array_key_exists($for, $finalMessages)) {
                $finalMessages[$for] = $message;
            }
        }

        array_push($this->rules[count($this->rules) - 1], ...$rules);
        array_push($this->specificMessages[count($this->specificMessages) - 1], ...$finalMessages);
        return $this;
    }

    public function validate(): void
    {
        if ($errors = $this->errors()) {
            throw new ValidationException($errors);
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

        foreach ($this->rules as $i => $ruleList) {
            $rowError = null;
            foreach ($ruleList as $j => $rule) {
                $this->callRule($rule, $fail);

                if ($lastError !== null) {
                    $rowError = $this->specificMessages[$i][$j] ?? $lastError->toString();
                    break;
                }
            }

            if ($rowError === null) {
                $this->errors = [];
                return true;
            } else {
                $this->errors[] = $rowError;
            }
        }

        return empty($this->errors);
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function errors(): array
    {
        $this->passes();

        return $this->errors;
    }

    public function error(): ?string
    {
        if ($this->passes()) {
            return null;
        }

        return $this->errors[0];
    }

    public function copyForEvent(Event $event): static
    {
        $validator = new static($event);
        $validator->rules = $this->rules;
        return $validator;
    }

    protected function callRule(mixed $rule, Closure $fail): void
    {
        [$rule, $args] = ValidationRuleParser::parse($rule);

        if (is_string($rule) && class_exists($rule)) {
            (new $rule(...$args))->validate($this->event, $fail);
        } elseif (is_string($rule)) {
            [$rule, $args] = ValidationRuleParser::parse($rule);

            $this->{'validate' . Str::pascal($rule)}($this->event, $fail, ...$args);
        } elseif ($rule instanceof Closure) {
            $rule($this->event, $fail);
        } else {
            $rule->validate($this->event, $fail);
        }
    }

    protected function validateFail(Event $event, $fail): void
    {
        $fail('memogram::validation.fail')->translate();
    }
}