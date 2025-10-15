<?php

namespace MemoGram\Handle;

/**
 * @template T
 * @property-read T $value
 */
class ReadonlyState
{
    public function __construct(
        protected mixed $_value,
    )
    {
    }

    public function __get(string $name)
    {
        if ($name == 'value') {
            return $this->_value;
        }

        return null;
    }
}