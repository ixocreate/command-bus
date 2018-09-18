<?php
declare(strict_types=1);
namespace KiwiSuite\CommandBus\Factory;

use KiwiSuite\CommandBus\Command\CommandSubManager;
use KiwiSuite\CommandBus\CommandBus;
use KiwiSuite\CommandBus\Config;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\Contract\ServiceManager\FactoryInterface;
use KiwiSuite\Contract\ServiceManager\ServiceManagerInterface;

final class CommandBusFactory implements FactoryInterface
{

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return mixed
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null)
    {
        return new CommandBus(
            $container->get(Config::class),
            $container->get(HandlerSubManager::class),
            $container->get(CommandSubManager::class)
        );
    }
}