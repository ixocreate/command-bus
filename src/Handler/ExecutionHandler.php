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
namespace KiwiSuite\CommandBus\Handler;

use KiwiSuite\CommandBus\Result\Result;
use KiwiSuite\Contract\CommandBus\CommandInterface;
use KiwiSuite\Contract\CommandBus\DispatchInterface;
use KiwiSuite\Contract\CommandBus\HandlerInterface;
use KiwiSuite\Contract\CommandBus\ResultInterface;

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
