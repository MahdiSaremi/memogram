<?php

namespace MemoGram\Handle;

/**
 * @template T
 * @property T $value
 * @property-read bool $isChanged
 * @extends ReadonlyState<T>
 */
class State extends ReadonlyState
{
    protected bool $_isChanged = false;

    public function __get(string $name)
    {
        return match ($name) {
            'value' => $this->_value,
            'isChanged' => $this->_isChanged,
        };
    }

    public function __set(string $name, $value): void
    {
        if ($name == 'value') {
            $this->isChanged = true;
            $this->_value = $value;
        }
    }
}