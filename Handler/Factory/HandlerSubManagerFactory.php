<?php
namespace KiwiSuite\CommandBus\Handler\Factory;

use KiwiSuite\CommandBus\Handler\HandlerInterface;
use KiwiSuite\CommandBus\Handler\HandlerServiceManagerConfig;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\ServiceManager\ServiceManagerInterface;
use KiwiSuite\ServiceManager\SubManager\SubManagerFactoryInterface;
use KiwiSuite\ServiceManager\SubManager\SubManagerInterface;

final class HandlerSubManagerFactory implements SubManagerFactoryInterface
{

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return SubManagerInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null): SubManagerInterface
    {
        return new HandlerSubManager(
            $container,
            $container->get(HandlerServiceManagerConfig::class),
            HandlerInterface::class
        );
    }
}
