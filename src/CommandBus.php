<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus;

use Ixocreate\CommandBus\Next\Next;
use Ixocreate\Contract\CommandBus\CommandInterface;
use Ixocreate\Contract\CommandBus\DispatchInterface;
use Ixocreate\Contract\CommandBus\ResultInterface;
use Psr\Container\ContainerInterface;

final class CommandBus implements DispatchInterface
{
    /**
     * @var Config
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
     * @param Config $config
     * @param ContainerInterface $handlerContainer
     * @param ContainerInterface $commandContainer
     */
    public function __construct(Config $config, ContainerInterface $handlerContainer, ContainerInterface $commandContainer)
    {
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
    public function create(string $name, array $data, ?string $uuid = null, ?\DateTimeInterface $createdAt = null): CommandInterface
    {
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
    public function command(string $name, array $data, ?string $uuid = null, ?\DateTimeInterface $createdAt = null): ResultInterface
    {
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
