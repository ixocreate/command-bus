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
namespace KiwiSuite\CommandBus\ConfiguratorItem;

use KiwiSuite\Application\ConfiguratorItem\ConfiguratorItemInterface;
use KiwiSuite\CommandBus\Handler\HandlerServiceManagerConfig;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

final class HandlerConfiguratorItem implements ConfiguratorItemInterface
{

    /**
     * @return mixed
     */
    public function getConfigurator()
    {
        return new ServiceManagerConfigurator(HandlerServiceManagerConfig::class);
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return 'handlerConfigurator';
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return 'handler.php';
    }

    /**
     * @param $configurator
     * @return \Serializable
     */
    public function getService($configurator): \Serializable
    {
        return $configurator->getServiceManagerConfig();
    }
}
