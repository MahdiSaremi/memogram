<?php

namespace MemoGram\Handle\Form\Prompts;

use MemoGram\Handle\Form\FormPrompt;
use MemoGram\Handle\Form\FormResponse;
use MemoGram\Handle\Form\PromptTemplate;

class ConfirmPrompt extends PromptTemplate
{
    public function __construct(
        protected ?string $confirm = null,
    )
    {
    }

    public function prompt(FormPrompt $prompt): FormPrompt
    {
        return $prompt
            ->onlyKeys();
    }

    public function response(FormPrompt $prompt, FormResponse $response): FormResponse
    {
        return $response
            ->schema([
                [$prompt->form->option($this->confirm ?? __('memogram::form.prompts.confirm'), true)],
            ]);
    }
}