<?php

namespace MemoGram\Response;

use Illuminate\Support\Traits\Conditionable;

class MessageResponse implements AsResponse
{
    use Conditionable;

    public ?string $message = null;
    public ?array $schema = null;
    public bool $resetKeyboard = false;
    public ?string $id = null;

    public function message(?string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function schema(?array $schema)
    {
        $this->schema = $schema;
        return $this;
    }

    public function resetKeyboard()
    {
        $this->resetKeyboard = true;
        return $this;
    }

    public function id(?string $id)
    {
        $this->id = $id;
        return $this;
    }
}