<?php

namespace MemoGram\Handle\Form;

use Closure;
use MemoGram\Handle\State;
use MemoGram\Response\Key;
use function MemoGram\Handle\eventHandler;
use function MemoGram\Handle\getEvent;
use function MemoGram\Handle\page;
use function MemoGram\Hooks\onMessage;
use function MemoGram\Hooks\refresh;

class Form
{
    protected array $responseUsing = [];
    protected ?FormPrompt $currentPrompt = null;
    protected ?Closure $validationErrorCallback = null;

    public function __construct(
        /** @var State<array> */
        protected State $values,
    )
    {
    }

    public static function use(): static
    {
        $values = page()->useState([]);

        return new static($values);
    }

    public function withCancel($action, $text = null)
    {
        $this->responseUsing['cancel'] = static fn(FormResponse $response) => $response->schemaUsing(
            static function (array $schema, $next) use ($action, $text): array {
                return [
                    ...$next($schema),
                    [\MemoGram\Hooks\key($text ?? __('memogram::form.cancel'))->then($action)],
                ];
            },
        );

        return $this;
    }

    public function withSkip($value = null, $text = null)
    {
        $this->responseUsing['skip'] = fn(FormResponse $response) => $response->schemaUsing(
            function (array $schema, $next) use ($value, $text): array {
                return $next([
                    [\MemoGram\Hooks\key($text ?? __('memogram::form.skip'))->then(function () use ($value) {
                        $this->set($this->currentPrompt()->name, $value);
                        refresh();
                    })],
                    ...$schema,
                ]);
            },
        );

        return $this;
    }

    public function onValidationError(Closure $callback)
    {
        $this->validationErrorCallback = $callback;
        return $this;
    }

    public function set(string $name, $value): void
    {
        $this->values->value[$name] = $value;
    }

    public function get(string $name, $default = null)
    {
        return array_key_exists($name, $this->values->value) ? $this->values->value[$name] : null;
    }

    public function forget(string $name): void
    {
        unset($this->values->value[$name]);
    }

    public function passed(string $name): bool
    {
        return array_key_exists($name, $this->values->value);
    }

    public function currentPrompt(): ?FormPrompt
    {
        return $this->currentPrompt;
    }

    public function response($message = null): FormResponse
    {
        $response = (new FormResponse());

        foreach ($this->responseUsing as $using) {
            $using($response);
        }

        return $response
            ->when($message !== null)->message($message);
    }

    public function prompt(string $name): FormPrompt
    {
        $prompt = $this->currentPrompt = new FormPrompt($this, $name);

        onMessage()->then(function () use ($name, $prompt) {
            if ($prompt->validator->passes()) {
                $value = $prompt->valueUsing ? ($prompt->valueUsing)(getEvent()) : null;
                $this->set($name, $value);
                refresh();
            } elseif ($this->validationErrorCallback) {
                eventHandler()->runAction($this->validationErrorCallback, $prompt->validator);
            } else {
                yield $prompt->validator->error();
            }
        });

        return $prompt;
    }

    public function option(string $text, $value): Key
    {
        return \MemoGram\Hooks\key($text)->then(function () use ($value) {
            $this->set($this->currentPrompt()->name, $value);
            refresh();
        });
    }
}