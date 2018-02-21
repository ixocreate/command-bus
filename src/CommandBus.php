<?php
namespace KiwiSuite\CommandBus;

use League\Tactician\CommandBus as Tactician;

final class CommandBus
{
    /**
     * @var Tactician
     */
    private $commandBus;

    public function __construct(array $middlewares)
    {
        $this->commandBus = new Tactician($middlewares);
    }

    public function handle($command)
    {
        $this->commandBus->handle($command);
    }

    public function __invoke($command)
    {
        return $this->handle($command);
    }
}
