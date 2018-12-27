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
namespace Ixocreate\CommandBus\Handler;

use Ixocreate\CommandBus\Result\Result;
use Ixocreate\Contract\CommandBus\CommandInterface;
use Ixocreate\Contract\CommandBus\DispatchInterface;
use Ixocreate\Contract\CommandBus\HandlerInterface;
use Ixocreate\Contract\CommandBus\ResultInterface;

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
