<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus;

use Ixocreate\CommandBus\Command\CommandInterface;
use Ixocreate\CommandBus\Dispatch\DispatchInterface;
use Ixocreate\CommandBus\Dispatch\Next;
use Ixocreate\CommandBus\Result\ResultInterface;
use Psr\Container\ContainerInterface;

final class CommandBus implements DispatchInterface
{
    /**
     * @var CommandBusConfigInterface
     */
    private $config;

    /**
     * @var ContainerInterface
     */
    private $handlerContainer;

    /**
     * @var ContainerInterface
     */
    private $commandContainer;

    /**
     * CommandBus constructor.
     *
     * @param CommandBusConfigInterface $config
     * @param ContainerInterface $handlerContainer
     * @param ContainerInterface $commandContainer
     */
    public function __construct(
        CommandBusConfigInterface $config,
        ContainerInterface $handlerContainer,
        ContainerInterface $commandContainer
    ) {
        /**
         * TODO: this should be detached from Config
         */
        $this->config = $config;
        $this->handlerContainer = $handlerContainer;
        $this->commandContainer = $commandContainer;
    }

    /**
     * @param string $name
     * @param array $data
     * @param null|string $uuid
     * @param \DateTimeInterface|null $createdAt
     * @return CommandInterface
     */
    public function create(
        string $name,
        array $data,
        ?string $uuid = null,
        ?\DateTimeInterface $createdAt = null
    ): CommandInterface {
        /** @var CommandInterface $command */
        $command = $this->commandContainer->get($name)->withData($data);

        if ($uuid !== null) {
            $command = $command->withUuid($uuid);
        }

        if ($createdAt !== null) {
            $command = $command->withCreatedAt($createdAt);
        }

        return $command;
    }

    /**
     * @param string $name
     * @param array $data
     * @param null|string $uuid
     * @param \DateTimeInterface|null $createdAt
     * @return ResultInterface
     */
    public function command(
        string $name,
        array $data,
        ?string $uuid = null,
        ?\DateTimeInterface $createdAt = null
    ): ResultInterface {
        return $this->dispatch($this->create($name, $data, $uuid, $createdAt));
    }

    /**
     * @param CommandInterface $command
     * @return ResultInterface
     */
    public function dispatch(CommandInterface $command): ResultInterface
    {
        $queue = new \SplQueue();
        foreach ($this->config->handlers() as $item) {
            $queue->enqueue($item);
        }

        $next = new Next($queue, $this->handlerContainer);
        return $next->dispatch($command);
    }
}
