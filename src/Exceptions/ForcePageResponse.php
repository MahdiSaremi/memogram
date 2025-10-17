<?php

namespace MemoGram\Exceptions;

class ForcePageResponse extends \Exception
{
    protected $response;

    public function __construct(
        $response,
    )
    {
        $this->response = value($response);

        parent::__construct("Force page response.");
    }

    public function getResponse(): mixed
    {
        return $this->response;
    }
}