<?php

namespace MemoGram\Handle;

abstract class Area
{
    public function middlewares(): array
    {
        return [];
    }

    public function back(): ?array
    {
        return null;
    }
}