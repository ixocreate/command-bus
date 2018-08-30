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
namespace KiwiSuiteTest\CommandBus\Next;

use KiwiSuite\CommandBus\Next\Next;
use KiwiSuite\Contract\CommandBus\CommandInterface;
use KiwiSuite\Contract\CommandBus\DispatchInterface;
use KiwiSuite\Contract\CommandBus\HandlerInterface;
use KiwiSuite\Contract\CommandBus\ResultInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class NextTest extends TestCase
{
    private $container;

    private $command;

    /**
     * @var MockObject
     */
    private $handler;

    public function setUp()
    {
        $this->command = $this->createMock(CommandInterface::class);

        $this->handler = $this->createMock(HandlerInterface::class);
        $this->handler->method("handle")->willReturnCallback(function (CommandInterface $command, DispatchInterface $dispatcher) {
            return $dispatcher->dispatch($command);
        });

        $this->container = $this->createMock(ContainerInterface::class);
        $this->container->method("get")
            ->willReturnCallback(function ($argument) {
                return $this->handler;
            });
    }

    /**
     * @covers \KiwiSuite\CommandBus\Next\Next::dispatch
     * @covers \KiwiSuite\CommandBus\Next\Next::__construct
     */
    public function testEmptyQueue()
    {
        $next = new Next(new \SplQueue(), $this->container);
        $result = $next->dispatch($this->command);

        $this->assertTrue($result->isSuccessful());
        $this->assertSame(ResultInterface::STATUS_DONE, $result->status());
        $this->assertSame($this->command, $result->command());
    }

    /**
     * @covers \KiwiSuite\CommandBus\Next\Next::dispatch
     * @covers \KiwiSuite\CommandBus\Next\Next::__construct
     */
    public function testPipeline()
    {
        $this->handler->expects($this->exactly(3))->method("handle");

        $queue = new \SplQueue();
        $queue->enqueue("handler1");
        $queue->enqueue("handler2");
        $queue->enqueue("handler3");

        $next = new Next($queue, $this->container);
        $result = $next->dispatch($this->command);

        $this->assertTrue($result->isSuccessful());
        $this->assertSame(ResultInterface::STATUS_DONE, $result->status());
        $this->assertSame($this->command, $result->command());
    }
}
