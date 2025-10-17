<?php

namespace MemoGram\Response;

use Illuminate\Support\Traits\Conditionable;

abstract class BaseResponse implements AsResponse
{
    use Conditionable;

    public ?string $id = null;

    public function id(?string $id)
    {
        $this->id = $id;
        return $this;
    }
}