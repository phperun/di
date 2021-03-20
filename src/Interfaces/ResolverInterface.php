<?php


namespace PHPerun\DI\Interfaces;


interface ResolverInterface
{
    public function __construct(PoolInterface $pool);

    public function resolve(string $key): mixed;

    public function invoke(object $object, string $method): mixed;
}