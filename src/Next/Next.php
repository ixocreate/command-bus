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
namespace KiwiSuite\CommandBus\Next;

use KiwiSuite\CommandBus\Result\Result;
use KiwiSuite\Contract\CommandBus\CommandInterface;
use KiwiSuite\Contract\CommandBus\DispatchInterface;
use KiwiSuite\Contract\CommandBus\HandlerInterface;
use KiwiSuite\Contract\CommandBus\ResultInterface;
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
