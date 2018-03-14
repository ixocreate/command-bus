<?php
namespace KiwiSuite\CommandBus\Factory;

use KiwiSuite\CommandBus\CommandBus;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\CommandBus\Plugin\HandlerPipePlugin;
use KiwiSuite\CommandBus\Plugin\TransformPlugin;
use KiwiSuite\Contract\ServiceManager\FactoryInterface;
use KiwiSuite\Contract\ServiceManager\ServiceManagerInterface;

final class CommandBusFactory implements FactoryInterface
{

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null)
    {
        $middlewarePipe = [
            new TransformPlugin(),
            new HandlerPipePlugin($container->get(HandlerSubManager::class))
        ];


        return new CommandBus($middlewarePipe);
    }
}
