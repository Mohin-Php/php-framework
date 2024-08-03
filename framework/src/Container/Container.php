<?php

namespace Mohin\Framework\Container;

use Psr\Container\ContainerInterface;

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

    public function resolve(string $id)
    {
        return $id;
    }


    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
//        return isset($this->services[$id]);
    }
}