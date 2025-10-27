<?php

namespace MemoGram\Handle;

class DynamicState extends State
{
    public function getStorableValue(): mixed
    {
        return array_map(fn(ReadonlyState $state) => $state->value, $this->_value);
    }

    public function dirty(): bool
    {
        if ($this->isDirty) {
            return true;
        }

        /** @var ReadonlyState $state */
        foreach ($this->_value as $state) {
            if ($state instanceof State && $state->dirty()) {
                return true;
            }
        }

        return false;
    }

    public function getDirtyStates(): array
    {
        $dirty = array_filter($this->_value, function (ReadonlyState $state) {
            return $state instanceof State && $state->dirty();
        });

        return array_merge(empty($dirty) ? [] : [$this], $dirty);
    }
}