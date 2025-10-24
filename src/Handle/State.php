<?php

namespace MemoGram\Handle;

use Closure;
use MemoGram\Support\Type;

/**
 * @template T
 * @property T $value
 * @extends ReadonlyState<T>
 */
class State extends ReadonlyState
{
    use Concerns\ManagesTypes;

    protected bool $isDirty = false;
    protected mixed $previousValue;
    protected string $serializedPreviousValue;
    protected Type $type;
    protected ?Closure $storeUsing = null;

    public function __construct(mixed $_value, bool $restored = false)
    {
        parent::__construct($_value, $restored);
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

    public function type(string|array $valid)
    {
        $this->type = Type::from($valid);
        return $this;
    }

    public function using(Closure $store, Closure $restore)
    {
        if ($this->restored) {
            $this->_value = $restore($this->_value);
        }

        $this->storeUsing = $store;
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

    public function getStorableValue(): mixed
    {
        return $this->storeUsing ? ($this->storeUsing)($this->_value) : $this->_value;
    }
}