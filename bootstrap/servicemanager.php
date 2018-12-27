<?php
declare(strict_types=1);
namespace Ixocreate\CommandBus;

use Ixocreate\CommandBus\Command\CommandSubManager;
use Ixocreate\CommandBus\Factory\CommandBusFactory;
use Ixocreate\CommandBus\Handler\HandlerSubManager;
use Ixocreate\ServiceManager\ServiceManagerConfigurator;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(CommandBus::class, CommandBusFactory::class);
$serviceManager->addSubManager(CommandSubManager::class);
$serviceManager->addSubManager(HandlerSubManager::class);
