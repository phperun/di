<?php


namespace PHPerun\DI\Interfaces;


interface ResolverInterface
{
    public function __construct(PoolInterface $pool);

    public function resolve(string $key): mixed;
}