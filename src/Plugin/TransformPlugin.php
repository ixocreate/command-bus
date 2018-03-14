<?php
/**
 * kiwi-suite/command-bus (https://github.com/kiwi-suite/command-bus)
 *
 * @package kiwi-suite/command-bus
 * @see https://github.com/kiwi-suite/command-bus
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuite\CommandBus\Plugin;

use KiwiSuite\CommandBus\Message\MessageInterface;
use KiwiSuite\CommandBus\Message\QueuedMessage;
use League\Tactician\Middleware;

final class TransformPlugin implements Middleware
{

    /**
     * @param MessageInterface $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof QueuedMessage) {
            $command = $command->getMessage();
        }

        return $next($command);
    }
}
