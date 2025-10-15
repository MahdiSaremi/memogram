<?php

namespace MemoGram\Api\Concerns;

use MemoGram\Api\Attributes\_Choose;
use ReflectionClass;
use ReflectionParameter;

trait Data
{
    public static function makeFromArray(array $data): static
    {
        $refClass = new ReflectionClass(static::class);
        $constructor = $refClass->getConstructor();

        if (! $constructor) {
            return new static();
        }

        $params = [];

        foreach ($constructor->getParameters() as $param) {
            $name = $param->getName();

            if (!array_key_exists($name, $data)) {
                $params[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
                continue;
            }

            $rawValue = $data[$name];
            $typeString = self::extractTypeFromDoc($param);

            $params[] = self::castValue($param, $typeString, $rawValue);
        }

        return new static(...$params);
    }

    protected static function castValue(\ReflectionParameter $param, ?string $typeString, mixed $value): mixed
    {
        if ($value === null || $typeString === null) {
            return $value;
        }

        if (in_array($typeString, ['int', 'float', 'string', 'bool', 'mixed', 'array'])) {
            settype($value, $typeString);
            return $value;
        }
        
        /** @var _Choose $choose */
        if (is_array($value) && $choose = (@$param->getAttributes(_Choose::class)[0])?->newInstance()) {
            $keyValue = $value[$choose->key];

            foreach ($choose->using as [$compare, $result]) {
                if ($compare === null || $keyValue == $compare) {
                    $className = $result;
                    break;
                }
            }
        }

        if (class_exists($className ??= "\\MemoGram\\Api\\Types\\$typeString") && is_array($value)) {
            if (method_exists($className, 'makeFromArray')) {
                return $className::makeFromArray($value);
            }
            return new $className(...$value);
        }

        if (preg_match('/^array<(.+)>$/', $typeString, $m)) {
            $innerType = $m[1];
            if (!is_array($value)) return [];

            return array_map(fn($item) => self::castValue($param, $innerType, $item), $value);
        }

        if (preg_match('/^array<array<(.+)>>$/', $typeString, $m)) {
            $innerType = $m[1];
            if (!is_array($value)) return [];

            return array_map(fn($row) =>
            array_map(fn($item) => self::castValue($param, $innerType, $item), $row),
                $value
            );
        }

        return $value;
    }

    protected static function extractTypeFromDoc(ReflectionParameter $param): ?string
    {
        $doc = (new \ReflectionProperty(static::class, $param->name))->getDocComment();
        if (!$doc) return null;

        if (preg_match('/@var\s+([^\s]+).*\b/', $doc, $m)) {
            return preg_replace('/(^null\||\?)|(\|null$)/', '', trim($m[1]));
        }

        return null;
    }
}