<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus\Handler;

use Ixocreate\CommandBus\Result\Result;
use Ixocreate\CommandBus\CommandInterface;
use Ixocreate\CommandBus\DispatchInterface;
use Ixocreate\CommandBus\HandlerInterface;
use Ixocreate\CommandBus\ResultInterface;

final class ExecutionHandler implements HandlerInterface
{
    /**
     * @param CommandInterface $command
     * @param DispatchInterface $dispatcher
     * @return ResultInterface
     */
    public function handle(CommandInterface $command, DispatchInterface $dispatcher): ResultInterface
    {
        $result = $command->execute();

        return new Result(
            ($result === false) ? ResultInterface::STATUS_ERROR : ResultInterface::STATUS_DONE,
            $command
        );
    }
}
