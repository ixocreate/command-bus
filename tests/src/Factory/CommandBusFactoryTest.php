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
namespace IxocreateTest\CommandBus\Factory;

use Ixocreate\CommandBus\CommandBus;
use Ixocreate\CommandBus\Config;
use Ixocreate\CommandBus\Factory\CommandBusFactory;
use Ixocreate\Contract\ServiceManager\ServiceManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class CommandBusFactoryTest extends TestCase
{
    /**
     * @covers \Ixocreate\CommandBus\Factory\CommandBusFactory::__invoke
     */
    public function testFactory()
    {
        $container = $this->createMock(ServiceManagerInterface::class);
        $container->method("get")->willReturnCallback(function ($param) {
            if ($param === Config::class) {
                return new Config([]);
            }
            return $this->createMock(ContainerInterface::class);
        });

        $commandBusFactory = new CommandBusFactory();

        $this->assertInstanceOf(CommandBus::class, $commandBusFactory($container, CommandBus::class));
    }
}
