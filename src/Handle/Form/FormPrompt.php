<?php

namespace MemoGram\Handle\Form;

use Closure;
use MemoGram\Api\Types\Update;
use MemoGram\Validation\Validation;
use MemoGram\Validation\Validator;
use function MemoGram\Hooks\refresh;

class FormPrompt
{
    public readonly Validator $validator;
    public ?Closure $valueUsing = null;

    /**
     * @var PromptTemplate[]
     */
    protected array $templates = [];

    protected array $then = [];

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

    public function rules($rule, $messages = [])
    {
        $this->validator->add($rule, $messages);
        return $this;
    }

    public function or()
    {
        $this->validator->or();
        return $this;
    }

    public function onlyKeys()
    {
        $this->validator->add('fail', __('memogram::form.only_keys'));
        return $this;
    }

    public function value(Closure $callback)
    {
        $this->valueUsing = $callback;
        return $this;
    }

    public function asText()
    {
        return $this->value(fn (Update $update) => $update->message->text ?? $update->message->caption);
    }

    public function asNumber()
    {
        return $this->value(fn (Update $update) => +($update->message->text ?? $update->message->caption));
    }

    public function template(string|PromptTemplate $template)
    {
        if (is_string($template)) {
            $template = new $template;
        }

        $template->prompt($this);
        $this->templates[] = $template;

        return $this;
    }

    public function setValue($value)
    {
        $this->form->set($this->name, $value);
        refresh();

        foreach ($this->then as $callback) {
            $callback();
        }
    }

    public function then(Closure $callback)
    {
        $this->then[] = $callback;
        return $this;
    }

    public function response($message = null): FormResponse
    {
        $response = $this->form->response($message);

        foreach ($this->templates as $template) {
            $response = $template->response($this, $response);
        }

        return $response;
    }
}