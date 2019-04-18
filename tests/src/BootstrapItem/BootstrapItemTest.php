<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus\BootstrapItem;

use Ixocreate\Package\CommandBus\BootstrapItem\BootstrapItem;
use Ixocreate\Package\CommandBus\Configurator;
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
     * @covers \Ixocreate\Package\CommandBus\BootstrapItem\BootstrapItem::getConfigurator
     */
    public function testGetConfigurator()
    {
        $this->assertInstanceOf(Configurator::class, $this->bootstrapItem->getConfigurator());
    }

    /**
     * @covers \Ixocreate\Package\CommandBus\BootstrapItem\BootstrapItem::getFileName
     */
    public function testGetFilename()
    {
        $this->assertSame('command-bus.php', $this->bootstrapItem->getFileName());
    }

    /**
     * @covers \Ixocreate\Package\CommandBus\BootstrapItem\BootstrapItem::getVariableName
     */
    public function testGetVariableName()
    {
        $this->assertSame('commandBus', $this->bootstrapItem->getVariableName());
    }
}
