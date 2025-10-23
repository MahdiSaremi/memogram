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
    protected array $errors;

    public function __construct(
        protected ?Event $event,
    )
    {
    }

    public function or()
    {
        $this->rules[] = [];
        return $this;
    }

    public function add($rule)
    {
        array_push($this->rules[count($this->rules) - 1], ...ValidationRuleParser::explode($rule));
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

        foreach ($this->rules as $ruleList) {
            foreach ($ruleList as $rule) {
                $this->callRule($rule, $fail);

                if ($lastError !== null) {
                    $this->errors[] = $lastError->toString();
                    $lastError = null;
                    break;
                } else {
                    $this->errors = [];
                    return true;
                }
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
}