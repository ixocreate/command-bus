<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus\BootstrapItem;

use Ixocreate\CommandBus\Package\Bootstrap\BootstrapItem;
use Ixocreate\CommandBus\Package\Configurator;
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
     * @covers \Ixocreate\CommandBus\Package\Bootstrap\BootstrapItem::getConfigurator
     */
    public function testGetConfigurator()
    {
        $this->assertInstanceOf(Configurator::class, $this->bootstrapItem->getConfigurator());
    }

    /**
     * @covers \Ixocreate\CommandBus\Package\Bootstrap\BootstrapItem::getFileName
     */
    public function testGetFilename()
    {
        $this->assertSame('command-bus.php', $this->bootstrapItem->getFileName());
    }

    /**
     * @covers \Ixocreate\CommandBus\Package\Bootstrap\BootstrapItem::getVariableName
     */
    public function testGetVariableName()
    {
        $this->assertSame('commandBus', $this->bootstrapItem->getVariableName());
    }
}
