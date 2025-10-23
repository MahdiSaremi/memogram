<?php

namespace MemoGram\Handle\Form;

use Closure;
use MemoGram\Validation\Validation;
use MemoGram\Validation\Validator;

class FormPrompt
{
    public readonly Validator $validator;
    public ?Closure $valueUsing = null;

    public function __construct(
        public readonly Form    $form,
        public readonly string  $name,
    )
    {
        $this->validator = Validation::make();
    }

    public function tapValidator(Closure $callback)
    {
        $callback($this->validator);
        return $this;
    }

    public function rules($rule)
    {
        $this->validator->add($rule);
        return $this;
    }

    public function or()
    {
        $this->validator->or();
        return $this;
    }

    public function value(Closure $callback)
    {
        $this->valueUsing = $callback;
        return $this;
    }

    public function response($message = null): FormResponse
    {
        return $this->form->response($message);
    }
}