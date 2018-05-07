<?php
declare(strict_types=1);
namespace KiwiSuite\CommandBus;

use KiwiSuite\CommandBus\Consumer\Consumer;
use KiwiSuite\CommandBus\Consumer\Factory\ConsumerFactory;
use KiwiSuite\CommandBus\Factory\CommandBusFactory;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\CommandBus\Message\MessageSubManager;
use KiwiSuite\CommandBus\QueueFactory\PersistentFactory;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addSubManager(HandlerSubManager::class);
$serviceManager->addSubManager(MessageSubManager::class);
$serviceManager->addFactory(CommandBus::class, CommandBusFactory::class);
$serviceManager->addFactory(PersistentFactory::class, \KiwiSuite\CommandBus\QueueFactory\Factory\PersistentFactory::class);
$serviceManager->addFactory(Consumer::class, ConsumerFactory::class);
