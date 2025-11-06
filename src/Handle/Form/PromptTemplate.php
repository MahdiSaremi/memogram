<?php

namespace MemoGram\Handle\Form;

abstract class PromptTemplate
{
    public function prompt(FormPrompt $prompt): FormPrompt
    {
        return $prompt;
    }

    public function response(FormPrompt $prompt, FormResponse $response): FormResponse
    {
        return $response;
    }
}