<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus\Dispatch;

use Ixocreate\CommandBus\Command\CommandInterface;
use Ixocreate\CommandBus\Result\ResultInterface;

interface DispatchInterface
{
    /**
     * @param CommandInterface $command
     * @return ResultInterface
     */
    public function dispatch(CommandInterface $command): ResultInterface;
}
