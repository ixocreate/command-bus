<?php
/**
 * kiwi-suite/command-bus (https://github.com/kiwi-suite/command-bus)
 *
 * @package kiwi-suite/command-bus
 * @link https://github.com/kiwi-suite/command-bus
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace Ixocreate\CommandBus;

use Ixocreate\CommandBus\Command\CommandSubManager;
use Ixocreate\CommandBus\Handler\HandlerSubManager;
use Ixocreate\Contract\Application\ConfiguratorInterface;
use Ixocreate\Contract\Application\ServiceRegistryInterface;
use Ixocreate\Contract\CommandBus\CommandInterface;
use Ixocreate\Contract\CommandBus\HandlerInterface;
use Ixocreate\ServiceManager\SubManager\SubManagerConfigurator;
use Zend\Stdlib\PriorityList;

final class Configurator implements ConfiguratorInterface
{
    /**
     * @var PriorityList
     */
    private $handlers;

    /**
     * @var SubManagerConfigurator
     */
    private $handlerSubManager;

    /**
     * @var SubManagerConfigurator
     */
    private $commandSubManager;

    public function __construct()
    {
        $this->handlers = new PriorityList();
        $this->handlerSubManager = new SubManagerConfigurator(HandlerSubManager::class, HandlerInterface::class);
        $this->commandSubManager = new SubManagerConfigurator(CommandSubManager::class, CommandInterface::class);
    }

    public function addHandler(string $name, ?string $factory = null, ?int $priority = 0): void
    {
        $this->handlers->insert($name, $factory, $priority);
        $this->handlerSubManager->addFactory($name, $factory);
    }

    public function addCommand(string $name, string $factory = null): void
    {
        $this->commandSubManager->addFactory($name, $factory);
    }

    public function addCommandDirectory(string $directory, bool $recursive = true): void
    {
        $this->commandSubManager->addDirectory($directory, $recursive, [CommandInterface::class]);
    }

    /**
     * @param ServiceRegistryInterface $serviceRegistry
     * @return void
     */
    public function registerService(ServiceRegistryInterface $serviceRegistry): void
    {
        $serviceRegistry->add(Config::class, new Config([
            'handlers' => \array_keys($this->handlers->toArray()),
        ]));

        $this->handlerSubManager->registerService($serviceRegistry);
        $this->commandSubManager->registerService($serviceRegistry);
    }
}
