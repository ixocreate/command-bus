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
namespace Ixocreate\CommandBus\Next;

use Ixocreate\CommandBus\Result\Result;
use Ixocreate\Contract\CommandBus\CommandInterface;
use Ixocreate\Contract\CommandBus\DispatchInterface;
use Ixocreate\Contract\CommandBus\HandlerInterface;
use Ixocreate\Contract\CommandBus\ResultInterface;
use Psr\Container\ContainerInterface;

final class Next implements DispatchInterface
{

    /**
     * @var \SplQueue
     */
    private $queue;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Next constructor.
     * @param \SplQueue $queue
     * @param ContainerInterface $container
     */
    public function __construct(\SplQueue $queue, ContainerInterface $container)
    {
        $this->queue = $queue;
        $this->container = $container;
    }

    /**
     * @param CommandInterface $command
     * @return ResultInterface
     */
    public function dispatch(CommandInterface $command): ResultInterface
    {
        if ($this->queue->isEmpty()) {
            return new Result(ResultInterface::STATUS_DONE, $command);
        }

        /** @var HandlerInterface $handler */
        $handler = $this->container->get($this->queue->dequeue());
        return $handler->handle($command, $this);
    }
}
