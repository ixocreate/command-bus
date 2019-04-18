<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus;

use Ixocreate\Package\CommandBus\Command\CommandSubManager;
use Ixocreate\Package\CommandBus\Config;
use Ixocreate\Package\CommandBus\Configurator;
use Ixocreate\Package\CommandBus\Handler\HandlerSubManager;
use Ixocreate\Application\ServiceRegistryInterface;
use Ixocreate\ServiceManager\ServiceManagerConfig;
use PHPUnit\Framework\TestCase;

class ConfiguratorTest extends TestCase
{
    /**
     * @covers \Ixocreate\Package\CommandBus\Configurator
     */
    public function testConfigurator()
    {
        $collector = [];
        $serviceRegistry = $this->createMock(ServiceRegistryInterface::class);
        $serviceRegistry->method('add')->willReturnCallback(function ($name, $object) use (&$collector) {
            $collector[$name] = $object;
        });

        $configurator = new Configurator();
        $configurator->addHandler('handler1', null, 5);
        $configurator->addHandler('handler2', null, 10);
        $configurator->addHandler('handler3', null, 1);

        $configurator->addCommand("command1");
        $configurator->addCommandDirectory(__DIR__);

        $configurator->registerService($serviceRegistry);

        $this->assertArrayHasKey(Config::class, $collector);
        $this->assertArrayHasKey(HandlerSubManager::class . '::Config', $collector);
        $this->assertArrayHasKey(CommandSubManager::class . '::Config', $collector);
        $this->assertInstanceOf(Config::class, $collector[Config::class]);
        $this->assertInstanceOf(ServiceManagerConfig::class, $collector[HandlerSubManager::class . '::Config']);
        $this->assertInstanceOf(ServiceManagerConfig::class, $collector[CommandSubManager::class . '::Config']);

        $this->assertSame(['handler2', 'handler1', 'handler3'], $collector[Config::class]->handlers());
        $this->assertArrayHasKey('handler1', $collector[HandlerSubManager::class . '::Config']->getFactories());
        $this->assertArrayHasKey('handler2', $collector[HandlerSubManager::class . '::Config']->getFactories());
        $this->assertArrayHasKey('handler3', $collector[HandlerSubManager::class . '::Config']->getFactories());
        $this->assertArrayHasKey('command1', $collector[CommandSubManager::class . '::Config']->getFactories());
    }
}
