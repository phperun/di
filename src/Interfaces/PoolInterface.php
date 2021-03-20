<?php


namespace PHPerun\DI\Interfaces;


interface PoolInterface
{
    public function get(string $key): mixed;

    public function has(string $key): bool;

    public function set(string $key, mixed $value): PoolInterface;
}