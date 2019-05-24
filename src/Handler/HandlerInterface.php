<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus\Handler;

use Ixocreate\CommandBus\Command\CommandInterface;
use Ixocreate\CommandBus\Dispatch\DispatchInterface;
use Ixocreate\CommandBus\Result\ResultInterface;

interface HandlerInterface
{
    /**
     * @param CommandInterface $command
     * @param DispatchInterface $dispatcher
     * @return ResultInterface
     */
    public function handle(CommandInterface $command, DispatchInterface $dispatcher): ResultInterface;
}
