<?php

namespace MemoGram\Exceptions;

class ValidationException extends \Exception
{
    public function __construct(
        public readonly array $messages,
    )
    {
        parent::__construct($messages[0] ?? "");
    }
}