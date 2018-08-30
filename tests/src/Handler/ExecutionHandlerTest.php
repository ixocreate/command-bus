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
namespace KiwiSuiteTest\CommandBus\Handler;

use KiwiSuite\CommandBus\Handler\ExecutionHandler;
use KiwiSuite\Contract\CommandBus\CommandInterface;
use KiwiSuite\Contract\CommandBus\DispatchInterface;
use PHPUnit\Framework\TestCase;

class ExecutionHandlerTest extends TestCase
{
    /**
     * @covers \KiwiSuite\CommandBus\Handler\ExecutionHandler::handle
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