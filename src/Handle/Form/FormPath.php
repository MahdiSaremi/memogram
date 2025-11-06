<?php

namespace MemoGram\Handle\Form;

use Closure;
use MemoGram\Handle\State;
use function MemoGram\Hooks\stopPage;
use function MemoGram\Hooks\useState;

class FormPath
{
    protected State $current;

    public function __construct(
        public readonly Form $form,
        protected array      $path,
    )
    {
        $this->path = array_values($this->path);
        $this->current = useState($path ? $path[0] : -1);
    }

    public function current(): string|int
    {
        return $this->current->value;
    }

    public function finished(): bool
    {
        return $this->current->value === -1;
    }

    public function is(string $name): bool
    {
        if ($this->current->value === -1) {
            return false;
        }

        return $this->current->value == $name;
    }

    public function reset(): void
    {
        $this->current->value = $this->path ? $this->path[0] : -1;
    }

    public function end(): void
    {
        $this->current->value = $this->path ? end($this->path) : -1;
    }

    public function next(): void
    {
        $index = array_search($this->current->value, $this->path);

        if ($index === false) {
            $this->reset();
        }

        $this->current->value = array_key_exists($index + 1, $this->path) ? $this->path[$index + 1] : -1;
    }

    public function previous(): void
    {
        $index = array_search($this->current->value, $this->path);

        if ($index === false) {
            $this->reset();
        }

        $this->current->value = array_key_exists($index - 1, $this->path) ? $this->path[$index - 1] : $this->current->value;
    }

    public function goto(string $name): void
    {
        $this->current->value = $name;
    }

    public function prompt(string $name, Closure $callback)
    {
        if ($this->is($name)) {
            yield $callback($this
                ->form
                ->prompt($name)
                ->then(function () {
                    $this->next();
                }),
            );

            yield stopPage();
        }
    }

    public function promptAll(array $callbacks)
    {
        foreach ($callbacks as $name => $callback) {
            yield from $this->prompt($name, $callback);
        }
    }
}