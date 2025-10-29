<?php

namespace MemoGram\Handle;

use Closure;
use MemoGram\Support\Type;
use function MemoGram\Hooks\hydrating;

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
    protected ?Closure $dirtySerializeUsing = null;
    protected ?Closure $checkDirty = null;

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

    public function using(Closure $store, Closure $restore, ?Closure $dirtySerialize = null)
    {
        if ($this->restored && hydrating()) {
            $this->_value = $restore($this->_value);
        }

        $this->storeUsing = $store;
        $this->dirtySerializeUsing = $dirtySerialize ?? $store;
        $this->sync();
        return $this;
    }

    public function checkDirtyUsing(Closure $callback)
    {
        $this->checkDirty = $callback;
        return $this;
    }

    public function serialize()
    {
        return $this->using(
            store: serialize(...),
            restore: unserialize(...),
        );
    }

    public function markAsDirty(): void
    {
        $this->isDirty = true;
    }

    public function dirty(): bool
    {
        if ($this->isDirty) {
            return true;
        }

        if ($this->checkDirty) {
            return ($this->checkDirty)($this->_value, $this->previousValue, $this->serializedPreviousValue);
        }

        return $this->serializeValue() != $this->serializedPreviousValue;
    }

    public function getDirtyStates(): array
    {
        if ($this->dirty()) {
            return [$this];
        }

        return [];
    }

    public function sync(): void
    {
        $this->isDirty = false;
        $this->previousValue = $this->_value;
        $this->serializedPreviousValue = $this->serializeValue();
    }

    protected function serializeValue()
    {
        return ($this->dirtySerializeUsing ?? 'serialize')($this->_value);
    }

    public function getStorableValue(): mixed
    {
        return $this->storeUsing ? ($this->storeUsing)($this->_value) : $this->_value;
    }
}