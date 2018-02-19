<?php
namespace KiwiSuite\CommandBus\Middleware;

use Bernard\Producer;
use KiwiSuite\CommandBus\Message\QueuedMessage;
use League\Tactician\Middleware;

final class QueueMiddleware implements Middleware
{

    /**
     * @var Producer
     */
    private $producer;

    /**
     * @param Producer $producer
     */
    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    /**
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof QueuedMessage) {
            $this->producer->produce($command);

            return;
        }

        return $next($command);
    }
}
