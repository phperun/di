<?php


namespace PHPerun\DI;


use PHPerun\DI\Interfaces\ContainerInterface;
use PHPerun\DI\Interfaces\PoolInterface;
use PHPerun\DI\Interfaces\ResolverInterface;
use PHPerun\DI\Lib\Pool;
use PHPerun\DI\Lib\Resolver;

class Container implements ContainerInterface
{
    protected PoolInterface $pool;
    protected ResolverInterface $resolver;

    public function __construct(?PoolInterface $pool = null, ?ResolverInterface $resolver = null)
    {
        $this->pool = $pool ?? new Pool();
        $this->resolver = $resolver ?? new Resolver($this->pool);
    }

    public function get(string $key): mixed
    {
        if ($this->pool->has($key)) {
            $value = $this->pool->get($key);

            if (is_callable($value)) {
                return $value($this);
            }

            return $value;
        }

        return $this->resolver->resolve($key);
    }

    public function has(string $key): bool
    {
        return $this->pool->has($key);
    }

    public function set(string $key, mixed $value): ContainerInterface
    {
        $this->pool->set($key, $value);

        return $this;
    }

    public function build(array $definitions): ContainerInterface
    {
        foreach ($definitions as $key => $value) {
            $this->pool->set($key, $value);
        }

        return $this;
    }

    public function invoke(string $class, string $method): mixed
    {
        $object = $this->get($class);

        return $this->resolver->invoke($object, $method);
    }
}