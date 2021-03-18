<?php


namespace PHPerun\DI\Lib;


use PHPerun\DI\Interfaces\PoolInterface;
use PHPerun\DI\Interfaces\ResolverInterface;

class Resolver implements ResolverInterface
{
    protected PoolInterface $pool;

    public function __construct(PoolInterface $pool)
    {
        $this->pool = $pool;
    }

    public function resolve(string $key): mixed
    {
        $reflection = $this->createReflection($key);

        return $this->resolveClass($reflection);
    }

    protected function createReflection(string $key): \ReflectionClass
    {
        return new \ReflectionClass($key);
    }

    protected function resolveClass(\ReflectionClass $reflection): mixed
    {
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return $reflection->newInstance();
        }

        $parameters = array_map(function ($parameter) {
            return $this->resolveParameter($parameter);
        }, $constructor->getParameters());

        return $reflection->newInstanceArgs($parameters);
    }

    protected function resolveParameter(\ReflectionParameter $parameter): mixed
    {
        $type = $parameter->getType();

        if ($type && !$type->isBuiltin()) {
            $reflection = $this->createReflection($type->getName());

            return $this->resolveClass($reflection);
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        if ($parameter->allowsNull()) {
            return null;
        }

        return null;
    }
}