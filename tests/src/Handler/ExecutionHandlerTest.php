<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus\Handler;

use Ixocreate\Package\CommandBus\Handler\ExecutionHandler;
use Ixocreate\Package\CommandBus\CommandInterface;
use Ixocreate\Package\CommandBus\DispatchInterface;
use PHPUnit\Framework\TestCase;

class ExecutionHandlerTest extends TestCase
{
    /**
     * @covers \Ixocreate\Package\CommandBus\Handler\ExecutionHandler::handle
     */
    public function testHandle()
    {
        $dispatcher = $this->createMock(DispatchInterface::class);
        $dispatcher->method("dispatch")->willThrowException(new \Exception());

        $command = $this->createMock(CommandInterface::class);
        $command->method("execute")->willReturn(true);
        $handler = new ExecutionHandler();
        $result = $handler->handle($command, $dispatcher);
        $this->assertTrue($result->isSuccessful());
        $this->assertSame($command, $result->command());

        $command = $this->createMock(CommandInterface::class);
        $command->method("execute")->willReturn(false);
        $handler = new ExecutionHandler();
        $result = $handler->handle($command, $dispatcher);
        $this->assertFalse($result->isSuccessful());
        $this->assertSame($command, $result->command());
    }
}
