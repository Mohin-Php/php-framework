<?php

namespace Mohin\Framework\Container;

use Psr\Container\ContainerInterface;
use ReflectionParameter;

class Container implements ContainerInterface
{
    private array $services = [];

    /**
     * @throws ContainerException
     */
    public function add(string $id, $concrete = null): void
    {
        if (null === $concrete) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id could not be added");
            }
            $concrete = $id;
        }

        $this->services[$id] = $concrete;
    }


    public function get(string $id)
    {
        if (!$this->has($id)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service $id could not be resolved");
            }
            $this->add($id);
        }
        return $this->resolve($this->services[$id]);
    }

    /**
     * @throws \ReflectionException
     */
    private function resolve($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            return $reflectionClass->newInstance();
        }
        $constructorParams = $constructor->getParameters();
        return $reflectionClass->newInstanceArgs($this->resolveClassDependencies($constructorParams));

    }

    private function resolveClassDependencies(array $reflectionParameters): array
    {


        $classDependencies = [];

        /** @var ReflectionParameter $parameter */
        foreach ($reflectionParameters as $parameter) {
            $classDependencies[] = $this->get($parameter->getType());
        }

        return $classDependencies;
    }


    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
//        return isset($this->services[$id]);
    }
}