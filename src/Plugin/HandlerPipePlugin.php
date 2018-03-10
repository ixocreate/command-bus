<?php
namespace KiwiSuite\CommandBus\Plugin;

use KiwiSuite\CommandBus\Handler\HandlerInterface;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\CommandBus\Message\MessageInterface;
use League\Tactician\Middleware;

final class HandlerPipePlugin implements Middleware
{
    /**
     * @var HandlerSubManager
     */
    private $handlerSubManager;

    /**
     * HandlerPipePlugin constructor.
     * @param HandlerSubManager $handlerSubManager
     */
    public function __construct(HandlerSubManager $handlerSubManager)
    {
        $this->handlerSubManager = $handlerSubManager;
    }

    /**
     * @param MessageInterface $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        if (!($command instanceof MessageInterface)) {
            return $next($command);
        }

        $handlerPipe = $command->handlers();

        foreach ($handlerPipe as $handler) {
            /** @var HandlerInterface $handler */
            $handler = $this->handlerSubManager->get($handler);

            $command = $handler->__invoke($command);
        }

        return $next($command);
    }
}
