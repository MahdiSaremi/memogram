<?php

namespace MemoGram\Validation;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MemoGram\Validation\Rules\ClosureValidationRule;

class ValidationRuleParser
{
    /**
     * Explode the explicit rule into an array if necessary.
     *
     * @param mixed $rule
     * @return array
     */
    public static function explode($rule)
    {
        if (is_string($rule)) {
            return explode('|', $rule);
        }

        if (is_object($rule)) {
            return Arr::wrap(static::prepareRule($rule));
        }

        $rules = [];

        foreach ($rule as $value) {
            $rules[] = static::prepareRule($value);
        }

        return $rules;
    }

    /**
     * Prepare the given rule for the Validator.
     *
     * @param mixed $rule
     * @return mixed
     */
    protected function prepareRule($rule)
    {
        if ($rule instanceof Closure) {
            $rule = new ClosureValidationRule($rule);
        }

        if (is_object($rule)) {
            return $rule;
        }

        return (string)$rule;
    }

    /**
     * Extract the rule name and parameters from a rule.
     *
     * @param array|string $rule
     * @return array
     */
    public static function parse($rule)
    {
        if (is_object($rule)) {
            return [$rule, []];
        }

        if (is_array($rule)) {
            $rule = static::parseArrayRule($rule);
        } else {
            $rule = static::parseStringRule($rule);
        }

        $rule[0] = static::normalizeRule($rule[0]);

        return $rule;
    }

    /**
     * Parse an array based rule.
     *
     * @param array $rule
     * @return array
     */
    protected static function parseArrayRule(array $rule)
    {
        return [Str::studly(trim(Arr::get($rule, 0, ''))), array_slice($rule, 1)];
    }

    /**
     * Parse a string based rule.
     *
     * @param string $rule
     * @return array
     */
    protected static function parseStringRule($rule)
    {
        $parameters = [];

        // The format for specifying validation rules and parameters follows an
        // easy {rule}:{parameters} formatting convention. For instance the
        // rule "Max:3" states that the value may only be three letters.
        if (str_contains($rule, ':')) {
            [$rule, $parameter] = explode(':', $rule, 2);

            $parameters = static::parseParameters($rule, $parameter);
        }

        return [Str::studly(trim($rule)), $parameters];
    }

    /**
     * Parse a parameter list.
     *
     * @param string $rule
     * @param string $parameter
     * @return array
     */
    protected static function parseParameters($rule, $parameter)
    {
        return static::ruleIsRegex($rule) ? [$parameter] : str_getcsv($parameter, escape: '\\');
    }

    /**
     * Determine if the rule is a regular expression.
     *
     * @param string $rule
     * @return bool
     */
    protected static function ruleIsRegex($rule)
    {
        return in_array(strtolower($rule), ['regex', 'not_regex', 'notregex'], true);
    }

    /**
     * Normalizes a rule so that we can accept short types.
     *
     * @param string $rule
     * @return string
     */
    protected static function normalizeRule($rule)
    {
        return match ($rule) {
            'Int' => 'Integer',
            'Bool' => 'Boolean',
            default => $rule,
        };
    }
}
