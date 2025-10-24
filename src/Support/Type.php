<?php

namespace MemoGram\Support;

class Type
{
    public function __construct(
        public array  $types,
        public array  $values,
        public array  $classes,
        public string $string,
    )
    {
    }

    public static function from(string|array $type): self
    {
        if (is_string($type)) {
            if (str_starts_with($type, '?')) {
                $type = 'null|' . substr($type, 1);
            }

            if (str_ends_with($type, '?')) {
                $type = 'null|' . substr($type, 0, -1);
            }

            $type = explode('|', $type);
        }

        $types = [];
        $values = [];
        $classes = [];
        $string = "";

        foreach ($type as $typ) {
            $typ = trim($typ);
            $string .= ($string ? '|' : '') . $typ;

            match (strtolower($typ)) {
                'bool', 'boolean' => $types[] = 'boolean',
                'int', 'integer' => $types[] = 'integer',
                'float', 'double' => $types[] = 'double',
                'string', 'array', 'resource', 'object' => $types[] = strtolower($typ),
                'null' => $types[] = 'NULL',
                'true' => $values[] = true,
                'false' => $values[] = false,
                default => class_exists($typ) ? $classes[] = $typ : throw new \InvalidArgumentException("Class [$typ] is not exists."),
            };
        }

        return new self($types, $values, $classes, $string);
    }

    public function validate($value): void
    {
        if (in_array(gettype($value), $this->types, true)) {
            return;
        }

        if (is_bool($value) && in_array($value, $this->values, true)) {
            return;
        }

        if (is_object($value)) {
            foreach ($this->classes as $class) {
                if (is_a($value, $class, true)) {
                    return;
                }
            }
        }

        throw new \TypeError("Expected {$this->string}, given " . (is_object($value) ? get_class($value) : gettype($value)));
    }
}