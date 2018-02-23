<?php
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
