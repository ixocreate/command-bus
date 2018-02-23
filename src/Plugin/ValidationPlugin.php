<?php
namespace KiwiSuite\CommandBus\Plugin;

use KiwiSuite\CommandBus\Message\MessageInterface;
use League\Tactician\Middleware;

final class ValidationPlugin implements Middleware
{

    /**
     * @param MessageInterface $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        if (!$command->isValidated()) {
            $result = $command->validate();
            if (!$result->isSuccessful()) {
                //TODO Exception
            }
        }

        return $next($command);
    }
}
