<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus;

use Ixocreate\CommandBus\Package\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @covers \Ixocreate\CommandBus\Package\Config::handlers
     * @covers \Ixocreate\CommandBus\Package\Config::__construct
     */
    public function testConfig()
    {
        $config = new Config([]);
        $this->assertSame([], $config->handlers());

        $config = new Config(['handlers' => ['handler1', 'handler2', 'handler3']]);
        $this->assertSame(['handler1', 'handler2', 'handler3'], $config->handlers());
    }

    /**
     * @covers \Ixocreate\CommandBus\Package\Config::serialize
     * @covers \Ixocreate\CommandBus\Package\Config::unserialize
     * @covers \Ixocreate\CommandBus\Package\Config::__construct
     */
    public function testSerializable()
    {
        $configOptions = ['handlers' => ['handler1', 'handler2', 'handler3']];
        $config = new Config($configOptions);
        $serialized = \serialize($config);
        $newConfig = \unserialize($serialized);
        $this->assertSame($config->handlers(), $newConfig->handlers());
    }
}
