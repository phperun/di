<?php


namespace PHPerun\DI\Interfaces;


interface ContainerInterface
{
    public function get(string $key): mixed;

    public function has(string $key): bool;

    public function set(string $key, mixed $value): ContainerInterface;

    public function build(array $definitions): ContainerInterface;

    public function invoke(string $class, string $method): mixed;
}