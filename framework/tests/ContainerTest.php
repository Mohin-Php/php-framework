<?php

use Mohin\Framework\Container\Container;
use Mohin\Framework\Container\ContainerException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DependantClass
{ public function __construct(private DependencyClass $dependency)
{
}

    public function getDependency(): DependencyClass
    {
        return $this->dependency;
    }

}

class DependencyClass
{

}


class ContainerTest extends TestCase
{
    #[Test]
    public function a_service_can_be_retrieved_from_the_container()
    {
        // Setup
        $container = new Container();

        // Do something
        // id string, concrete class name string | object
        $container->add('dependant-class', DependantClass::class);

        // Make assertions
        $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
    }

    #[Test]
    public function a_ContainerException_is_thrown_if_a_service_cannot_be_found()
    {
        // Setup
        $container = new Container();

        // Expect exception
        $this->expectException(ContainerException::class);

        // Do something
        $container->add('foobar');
    }

    #[Test]
    public function can_check_if_the_container_has_a_service()
    {
        $container = new Container();
        $container->add('dependant-class', DependantClass::class);
        $this->assertTrue($container->has('dependant-class'));
        $this->assertFalse($container->has('mohin'));
    }

    #[Test]
    public function services_can_be_recursively_autowired(): void
    {
        $container = new Container();

        $dependantService = $container->get(DependantClass::class);

        $dependancyService = $dependantService->getDependency();

        $this->assertInstanceOf(DependencyClass::class, $dependancyService);
    }
}