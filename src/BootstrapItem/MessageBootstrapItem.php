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

use KiwiSuite\CommandBus\Message\MessageConfigurator;
use KiwiSuite\Contract\Application\BootstrapItemInterface;
use KiwiSuite\Contract\Application\ConfiguratorInterface;

final class MessageBootstrapItem implements BootstrapItemInterface
{
    /**
     * @return ConfiguratorInterface
     */
    public function getConfigurator(): ConfiguratorInterface
    {
        return new MessageConfigurator();
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return 'message';
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return 'message.php';
    }
}
