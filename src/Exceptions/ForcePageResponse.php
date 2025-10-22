<?php

namespace MemoGram\Exceptions;

class ForcePageResponse extends \Exception
{
    protected $response;

    public function __construct(
        $response,
        protected bool $refresh = false,
    )
    {
        $this->response = value($response);

        parent::__construct("Force page response.");
    }

    public function getResponse(): mixed
    {
        return $this->response;
    }

    public function getRefresh(): bool
    {
        return $this->refresh;
    }
}