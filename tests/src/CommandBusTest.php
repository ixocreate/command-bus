<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace IxocreateTest\CommandBus;

use Ixocreate\CommandBus\CommandBus;
use Ixocreate\CommandBus\Config;
use Ixocreate\Contract\CommandBus\CommandInterface;
use Ixocreate\Contract\CommandBus\DispatchInterface;
use Ixocreate\Contract\CommandBus\HandlerInterface;
use Ixocreate\Contract\CommandBus\ResultInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

class CommandBusTest extends TestCase
{
    private $command;

    private $handler;

    private $handlerContainer;

    private $commandContainer;

    private $config;

    public function setUp()
    {
        $this->command = $this->createMock(CommandInterface::class);
        $this->command->method("withUuid")->willReturnSelf();
        $this->command->method("withCreatedAt")->willReturnSelf();
        $this->command->method("withData")->willReturnSelf();

        $this->handler = $this->createMock(HandlerInterface::class);
        $this->handler->method("handle")->willReturnCallback(function (CommandInterface $command, DispatchInterface $dispatcher) {
            return $dispatcher->dispatch($command);
        });

        $this->handlerContainer = $this->createMock(ContainerInterface::class);
        $this->handlerContainer->method("get")
            ->willReturnCallback(function ($argument) {
                return $this->handler;
            });

        $this->commandContainer = $this->createMock(ContainerInterface::class);
        $this->commandContainer->method("get")
            ->willReturnCallback(function ($argument) {
                return $this->command;
            });

        $this->config = new Config(['handlers' => ['handler1', 'handler2']]);
    }

    /**
     * @covers \Ixocreate\CommandBus\CommandBus::create
     * @covers \Ixocreate\CommandBus\CommandBus::__construct
     */
    public function testCreateWithoutDefault()
    {
        $this->command->expects($this->once())->method("withUuid");
        $this->command->expects($this->once())->method("withData");
        $this->command->expects($this->once())->method("withCreatedAt");


        $commandBus = new CommandBus($this->config, $this->handlerContainer, $this->commandContainer);
        $command = $commandBus->create("test", ['data'], Uuid::uuid4()->toString(), new \DateTimeImmutable());
        $this->assertInstanceOf(CommandInterface::class, $command);
    }

    /**
     * @covers \Ixocreate\CommandBus\CommandBus::create
     * @covers \Ixocreate\CommandBus\CommandBus::__construct
     */
    public function testCreateWithDefault()
    {
        $this->command->expects($this->never())->method("withUuid");
        $this->command->expects($this->once())->method("withData");
        $this->command->expects($this->never())->method("withCreatedAt");


        $commandBus = new CommandBus($this->config, $this->handlerContainer, $this->commandContainer);
        $command = $commandBus->create("test", ['data']);
        $this->assertInstanceOf(CommandInterface::class, $command);
    }

    /**
     * @covers \Ixocreate\CommandBus\CommandBus::dispatch
     * @covers \Ixocreate\CommandBus\CommandBus::__construct
     */
    public function testDispatch()
    {
        $this->handler->expects($this->exactly(2))->method("handle");
        $commandBus = new CommandBus($this->config, $this->handlerContainer, $this->commandContainer);

        $result = $commandBus->dispatch($this->command);
        $this->assertInstanceOf(ResultInterface::class, $result);
    }

    /**
     * @covers \Ixocreate\CommandBus\CommandBus::command
     * @covers \Ixocreate\CommandBus\CommandBus::__construct
     */
    public function testCommandWithoutDefault()
    {
        $this->command->expects($this->once())->method("withUuid");
        $this->command->expects($this->once())->method("withData");
        $this->command->expects($this->once())->method("withCreatedAt");
        $this->handler->expects($this->exactly(2))->method("handle");

        $commandBus = new CommandBus($this->config, $this->handlerContainer, $this->commandContainer);
        $result = $commandBus->command("test", ['data'], Uuid::uuid4()->toString(), new \DateTimeImmutable());
        $this->assertInstanceOf(ResultInterface::class, $result);
    }

    /**
     * @covers \Ixocreate\CommandBus\CommandBus::command
     * @covers \Ixocreate\CommandBus\CommandBus::__construct
     */
    public function testCommandWithDefault()
    {
        $this->command->expects($this->never())->method("withUuid");
        $this->command->expects($this->once())->method("withData");
        $this->command->expects($this->never())->method("withCreatedAt");
        $this->handler->expects($this->exactly(2))->method("handle");

        $commandBus = new CommandBus($this->config, $this->handlerContainer, $this->commandContainer);
        $result = $commandBus->command("test", ['data']);
        $this->assertInstanceOf(ResultInterface::class, $result);
    }
}
