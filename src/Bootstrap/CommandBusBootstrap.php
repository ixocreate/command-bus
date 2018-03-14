<?php
/**
 * kiwi-suite/command-bus (https://github.com/kiwi-suite/command-bus)
 *
 * @package kiwi-suite/command-bus
 * @see https://github.com/kiwi-suite/command-bus
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuite\CommandBus\Bootstrap;

use KiwiSuite\Application\Bootstrap\BootstrapInterface;
use KiwiSuite\Application\ConfiguratorItem\ConfiguratorRegistry;
use KiwiSuite\Application\ConfiguratorItem\ServiceManagerConfiguratorItem;
use KiwiSuite\Application\Service\ServiceRegistry;
use KiwiSuite\ApplicationConsole\ConfiguratorItem\ConsoleConfiguratorItem;
use KiwiSuite\CommandBus\CommandBus;
use KiwiSuite\CommandBus\ConfiguratorItem\HandlerConfiguratorItem;
use KiwiSuite\CommandBus\ConfiguratorItem\MessageConfiguratorItem;
use KiwiSuite\CommandBus\Console\ConsumeCommand;
use KiwiSuite\CommandBus\Consumer\Consumer;
use KiwiSuite\CommandBus\Consumer\Factory\ConsumerFactory;
use KiwiSuite\CommandBus\Factory\CommandBusFactory;
use KiwiSuite\CommandBus\Handler\Factory\HandlerSubManagerFactory;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\CommandBus\Message\Factory\MessageSubManagerFactory;
use KiwiSuite\CommandBus\Message\MessageSubManager;
use KiwiSuite\CommandBus\QueueFactory\PersistentFactory;
use KiwiSuite\ServiceManager\ServiceManager;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

final class CommandBusBootstrap implements BootstrapInterface
{

    /**
     * @param ConfiguratorRegistry $configuratorRegistry
     */
    public function configure(ConfiguratorRegistry $configuratorRegistry): void
    {
        /** @var ServiceManagerConfigurator $serviceManagerConfigurator */
        $serviceManagerConfigurator = $configuratorRegistry->get(ServiceManagerConfiguratorItem::class);

        $serviceManagerConfigurator->addSubManager(HandlerSubManager::class, HandlerSubManagerFactory::class);
        $serviceManagerConfigurator->addSubManager(MessageSubManager::class, MessageSubManagerFactory::class);
        $serviceManagerConfigurator->addFactory(CommandBus::class, CommandBusFactory::class);
        $serviceManagerConfigurator->addFactory(PersistentFactory::class, \KiwiSuite\CommandBus\QueueFactory\Factory\PersistentFactory::class);
        $serviceManagerConfigurator->addFactory(Consumer::class, ConsumerFactory::class);

        if ($configuratorRegistry->has(ConsoleConfiguratorItem::class)) {
            $consoleConfigurator = $configuratorRegistry->get(ConsoleConfiguratorItem::class);
            $consoleConfigurator->addFactory(ConsumeCommand::class);
        }
    }

    /**
     * @param ServiceRegistry $serviceRegistry
     */
    public function addServices(ServiceRegistry $serviceRegistry): void
    {
    }

    /**
     * @return array|null
     */
    public function getConfiguratorItems(): ?array
    {
        return [
            HandlerConfiguratorItem::class,
            MessageConfiguratorItem::class,
        ];
    }

    /**
     * @return array|null
     */
    public function getDefaultConfig(): ?array
    {
        return null;
    }

    /**
     * @param ServiceManager $serviceManager
     */
    public function boot(ServiceManager $serviceManager): void
    {
    }
}
