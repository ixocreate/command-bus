<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus\Dispatch;

use Ixocreate\CommandBus\Command\CommandInterface;
use Ixocreate\CommandBus\Handler\HandlerInterface;
use Ixocreate\CommandBus\Result\Result;
use Ixocreate\CommandBus\Result\ResultInterface;
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
     *
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
