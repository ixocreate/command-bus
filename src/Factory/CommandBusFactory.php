<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus\Factory;

use Ixocreate\CommandBus\Command\CommandSubManager;
use Ixocreate\CommandBus\CommandBus;
use Ixocreate\CommandBus\Config;
use Ixocreate\CommandBus\Handler\HandlerSubManager;
use Ixocreate\Contract\ServiceManager\FactoryInterface;
use Ixocreate\Contract\ServiceManager\ServiceManagerInterface;

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
