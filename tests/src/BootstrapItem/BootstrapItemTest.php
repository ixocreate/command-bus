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
namespace KiwiSuiteTest\CommandBus\BootstrapItem;

use KiwiSuite\CommandBus\BootstrapItem\BootstrapItem;
use KiwiSuite\CommandBus\Configurator;
use PHPUnit\Framework\TestCase;

class BootstrapItemTest extends TestCase
{
    /**
     * @var BootstrapItem
     */
    private $bootstrapItem;

    /**
     *
     */
    public function setUp()
    {
        $this->bootstrapItem = new BootstrapItem();
    }

    /**
     * @covers \KiwiSuite\CommandBus\BootstrapItem\BootstrapItem::getConfigurator
     */
    public function testGetConfigurator()
    {
        $this->assertInstanceOf(Configurator::class, $this->bootstrapItem->getConfigurator());
    }

    /**
     * @covers \KiwiSuite\CommandBus\BootstrapItem\BootstrapItem::getFileName
     */
    public function testGetFilename()
    {
        $this->assertSame('command-bus.php', $this->bootstrapItem->getFileName());
    }

    /**
     * @covers \KiwiSuite\CommandBus\BootstrapItem\BootstrapItem::getVariableName
     */
    public function testGetVariableName()
    {
        $this->assertSame('commandBus', $this->bootstrapItem->getVariableName());
    }
}
