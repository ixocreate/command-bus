<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus\BootstrapItem;

use Ixocreate\CommandBus\Bootstrap\BootstrapItem;
use Ixocreate\CommandBus\Configurator;
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
     * @covers \Ixocreate\CommandBus\Bootstrap\Bootstrap::getConfigurator
     */
    public function testGetConfigurator()
    {
        $this->assertInstanceOf(Configurator::class, $this->bootstrapItem->getConfigurator());
    }

    /**
     * @covers \Ixocreate\CommandBus\Bootstrap\Bootstrap::getFileName
     */
    public function testGetFilename()
    {
        $this->assertSame('command-bus.php', $this->bootstrapItem->getFileName());
    }

    /**
     * @covers \Ixocreate\CommandBus\Bootstrap\Bootstrap::getVariableName
     */
    public function testGetVariableName()
    {
        $this->assertSame('commandBus', $this->bootstrapItem->getVariableName());
    }
}
