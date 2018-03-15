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
namespace KiwiSuite\CommandBus\BootstrapItem;

use KiwiSuite\CommandBus\Handler\HandlerConfigurator;
use KiwiSuite\Contract\Application\BootstrapItemInterface;
use KiwiSuite\Contract\Application\ConfiguratorInterface;

final class HandlerBootstrapItem implements BootstrapItemInterface
{
    /**
     * @return ConfiguratorInterface
     */
    public function getConfigurator(): ConfiguratorInterface
    {
        return new HandlerConfigurator();
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return 'handler';
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return 'handler.php';
    }
}
