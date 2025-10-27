<?php

namespace MemoGram\Handle;

class GarbageState
{
    protected mixed $actualValue;
    protected bool $used = false;

    public function __construct(
        protected State $state,
        protected mixed $default = null,
    )
    {
        $this->actualValue = $state->value;
        $state->value = $default;
    }

    public function use()
    {
        if (!$this->used) {
            $this->used = true;
            $this->state->value = $this->actualValue;
            $this->state->sync();
        }

        return $this->state;
    }
}