<?php
declare(strict_types=1);
namespace KiwiSuite\CommandBus;

use KiwiSuite\CommandBus\Command\CommandSubManager;
use KiwiSuite\CommandBus\Factory\CommandBusFactory;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(CommandBus::class, CommandBusFactory::class);
$serviceManager->addSubManager(CommandSubManager::class);
$serviceManager->addSubManager(HandlerSubManager::class);
