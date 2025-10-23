<?php

namespace MemoGram\Exceptions;

class StopPage extends \Exception
{
    public function __construct()
    {
        parent::__construct("Stop page exception");
    }
}