<?php


namespace PHPerun\DI\Lib;


use PHPerun\DI\Interfaces\PoolInterface;

class Pool implements PoolInterface
{
    protected array $pool = [];

    public function get(string $key): mixed
    {
        return $this->pool[$key];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->pool);
    }

    public function set(string $key, mixed $value): PoolInterface
    {
        $this->pool[$key] = $value;

        return $this;
    }
}