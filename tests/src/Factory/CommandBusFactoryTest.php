<?php
declare(strict_types=1);
namespace KiwiSuiteTest\CommandBus\Factory;

use KiwiSuite\CommandBus\CommandBus;
use KiwiSuite\CommandBus\Config;
use KiwiSuite\CommandBus\Factory\CommandBusFactory;
use KiwiSuite\Contract\ServiceManager\ServiceManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class CommandBusFactoryTest extends TestCase
{
    /**
     * @covers \KiwiSuite\CommandBus\Factory\CommandBusFactory::__invoke
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