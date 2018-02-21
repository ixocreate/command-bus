<?php
namespace KiwiSuite\CommandBus\Middleware;

use KiwiSuite\CommandBus\Message\QueueableMessageInterface;
use KiwiSuite\CommandBus\Message\QueuedMessage;
use League\Tactician\Middleware;

final class TransformQueueMiddleware implements Middleware
{

    /**
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof QueueableMessageInterface) {
            $command = new QueuedMessage($command);
        } elseif ($command instanceof QueuedMessage) {
            $command = $command->getCommand();
        }

        return $next($command);
    }
}
