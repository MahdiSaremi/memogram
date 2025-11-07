<?php

namespace MemoGram\Handle;

use Illuminate\Support\Arr;
use MemoGram\Handle\Attributes\Back;
use MemoGram\Handle\Attributes\Middleware as MiddlewareAttribute;
use ReflectionClass;
use ReflectionMethod;

class AreaRegistry
{
    protected function middlewareOptions(): array
    {
        return [
            'method.attribute' => MiddlewareAttribute::class,
            'method.attribute.using' => static fn(MiddlewareAttribute $attr) => Arr::wrap($attr->middleware),
            'class.attribute' => MiddlewareAttribute::class,
            'class.attribute.using' => static fn(MiddlewareAttribute $attr) => Arr::wrap($attr->middleware),
            'area.class' => "_Middleware",
            'area.method' => "middlewares",
        ];
    }

    public function getMiddlewaresForMethod(string $class, string $method): array
    {
        return $this->getFeatureForMethod($class, $method, $this->middlewareOptions());
    }

    public function getMiddlewaresForClass(string $class): array
    {
        return $this->getFeatureForClass($class, $this->middlewareOptions());
    }

    public function getMiddlewaresForNamespace(string $namespace): array
    {
        return $this->getFeatureForNamespace($namespace, $this->middlewareOptions());
    }


    protected function backOptions(): array
    {
        return [
            'method.attribute' => Back::class,
            'method.attribute.using' => static fn(Back $attr) => [$attr->page],
            'class.attribute' => Back::class,
            'class.attribute.using' => static fn(Back $attr) => [$attr->page],
            'area.using' => static fn(Area $area) => [$area->back()],
        ];
    }

    public function getBackForMethod(string $class, string $method): ?array
    {
        foreach (array_reverse($this->getFeatureForMethod($class, $method, $this->backOptions())) as $back) {
            if ($back !== null) {
                return $back;
            }
        }

        return null;
    }

    public function getBackForClass(string $class): ?array
    {
        foreach (array_reverse($this->getFeatureForClass($class, $this->backOptions())) as $back) {
            if ($back !== null) {
                return $back;
            }
        }

        return null;
    }

    public function getBackForNamespace(string $namespace): ?array
    {
        foreach (array_reverse($this->getFeatureForNamespace($namespace, $this->backOptions())) as $back) {
            if ($back !== null) {
                return $back;
            }
        }

        return null;
    }


    public function getFeatureForMethod(string $class, string $method, array $options, ?string $reference = null): array
    {
        $reference ??= "$class@$method";
        $result = $this->getFeatureForClass($class, $options, $reference);

        if (isset($options['method.attribute'])) {
            foreach ((new ReflectionMethod($class, $method))->getAttributes($options['method.attribute']) as $attr) {
                $attr = $attr->newInstance();

                array_push($result, ...isset($options['method.attribute.using']) ? $options['method.attribute.using']($attr) : [$attr]);
            }
        }

        return $result;
    }

    public function getFeatureForClass(string $class, array $options, ?string $reference = null): array
    {
        $reference ??= $class;
        $result = $this->getFeatureForNamespace(class_basename($class), $options, $reference);

        if (isset($options['class.attribute'])) {
            foreach ((new ReflectionClass($class))->getAttributes($options['class.attribute']) as $attr) {
                $attr = $attr->newInstance();

                array_push($result, ...isset($options['class.attribute.using']) ? $options['class.attribute.using']($attr) : [$attr]);
            }
        }

        return $result;
    }

    public function getFeatureForNamespace(string $namespace, array $options, ?string $reference = null): array
    {
        $reference ??= $namespace;
        $result = [];

        $partition = $namespace;
        do {
            $namespaceResult = [];

            if (isset($options['area.class']) && class_exists($class = $partition . "\\" . $options['area.class'])) {
                $namespaceResult[] = new $class;
            }

            if ((isset($options['area.method']) || isset($options['area.using'])) && class_exists($class = "$partition\\_Area")) {
                /** @var Area $area */
                $area = new $class($reference);

                if (isset($options['area.method']) && method_exists($area, $options['area.method'])) {
                    array_push($namespaceResult, ...$area->{$options['area.method']}());
                }

                if (isset($options['area.using'])) {
                    array_push($namespaceResult, ...$options['area.using']($area));
                }
            }

            array_unshift($result, ...$namespaceResult);
        } while (str_contains($namespace, '\\') && $partition = class_basename($namespace));

        return $result;
    }
}