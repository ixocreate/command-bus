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
namespace KiwiSuiteTest\CommandBus;

use KiwiSuite\CommandBus\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @covers \KiwiSuite\CommandBus\Config::handlers
     * @covers \KiwiSuite\CommandBus\Config::__construct
     */
    public function testConfig()
    {
        $config = new Config([]);
        $this->assertSame([], $config->handlers());

        $config = new Config(['handlers' => ['handler1', 'handler2', 'handler3']]);
        $this->assertSame(['handler1', 'handler2', 'handler3'], $config->handlers());
    }

    /**
     * @covers \KiwiSuite\CommandBus\Config::serialize
     * @covers \KiwiSuite\CommandBus\Config::unserialize
     * @covers \KiwiSuite\CommandBus\Config::__construct
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
