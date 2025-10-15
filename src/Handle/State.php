<?php

namespace MemoGram\Handle;

/**
 * @template T
 * @property T $value
 * @extends ReadonlyState<T>
 */
class State extends ReadonlyState
{
    public function __get(string $name)
    {
        if ($name == 'value') {
            return $this->_value;
        }

        return null;
    }

    public function __set(string $name, $value): void
    {
        if ($name == 'value') {
            $this->_value = $value;
        }
    }
}