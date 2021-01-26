<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus\Handler;

use Ixocreate\CommandBus\Command\CommandInterface;
use Ixocreate\CommandBus\Dispatch\DispatchInterface;
use Ixocreate\CommandBus\Handler\ExecutionHandler;
use PHPUnit\Framework\TestCase;

class ExecutionHandlerTest extends TestCase
{
    /**
     * @covers \Ixocreate\CommandBus\Handler\ExecutionHandler::handle
     */
    public function testHandle()
    {
        $dispatcher = $this->createMock(DispatchInterface::class);
        $dispatcher->method('dispatch')->willThrowException(new \Exception());

        $command = $this->createMock(CommandInterface::class);
        $command->method('execute')->willReturn(true);
        $handler = new ExecutionHandler();
        $result = $handler->handle($command, $dispatcher);
        $this->assertTrue($result->isSuccessful());
        $this->assertSame($command, $result->command());

        $command = $this->createMock(CommandInterface::class);
        $command->method('execute')->willReturn(false);
        $handler = new ExecutionHandler();
        $result = $handler->handle($command, $dispatcher);
        $this->assertFalse($result->isSuccessful());
        $this->assertSame($command, $result->command());
    }
}
