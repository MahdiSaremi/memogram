<?php

namespace MemoGram\Handle;

/**
 * @template T
 * @property T $value
 * @extends ReadonlyState<T>
 */
class State extends ReadonlyState
{
    protected bool $isDirty = false;
    protected mixed $previousValue;
    protected string $serializedPreviousValue;

    public function __construct(mixed $_value)
    {
        parent::__construct($_value);
        $this->sync();
    }

    public function &__get(string $name)
    {
        if ($name == 'value') {
            return $this->_value;
        }

        throw new \InvalidArgumentException("Property [$name] does not exist.");
    }

    public function __set(string $name, $value): void
    {
        if ($name == 'value') {
            $this->isDirty = true;
            $this->_value = $value;
            return;
        }

        throw new \InvalidArgumentException("Property [$name] does not exist.");
    }

    public function markAsDirty(): void
    {
        $this->isDirty = true;
    }

    public function dirty(): bool
    {
        return $this->isDirty
            || $this->previousValue !== $this->_value
            || (is_object($this->previousValue) && $this->serializedPreviousValue !== serialize($this->_value));
    }

    public function sync(): void
    {
        $this->isDirty = false;
        $this->previousValue = $this->_value;
        if (is_object($this->_value)) {
            $this->serializedPreviousValue = serialize($this->_value);
        } else {
            unset($this->serializedPreviousValue);
        }
    }
}