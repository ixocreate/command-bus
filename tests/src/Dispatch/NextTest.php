<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus\Dispatch;

use Ixocreate\CommandBus\Command\CommandInterface;
use Ixocreate\CommandBus\Dispatch\DispatchInterface;
use Ixocreate\CommandBus\Dispatch\Next;
use Ixocreate\CommandBus\Handler\HandlerInterface;
use Ixocreate\CommandBus\Result\ResultInterface;
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
     * @covers \Ixocreate\CommandBus\Dispatch\Next::dispatch
     * @covers \Ixocreate\CommandBus\Dispatch\Next::__construct
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
     * @covers \Ixocreate\CommandBus\Dispatch\Next::dispatch
     * @covers \Ixocreate\CommandBus\Dispatch\Next::__construct
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
