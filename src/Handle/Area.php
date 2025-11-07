<?php

namespace MemoGram\Handle;

abstract class Area
{
    public function __construct(
        protected string $reference,
    )
    {
    }

    public function middlewares(): array
    {
        return [];
    }

    public function back(): ?array
    {
        return null;
    }
}