<?php
namespace KiwiSuite\CommandBus;

use KiwiSuite\CommandBus\Message\MessageInterface;
use League\Tactician\CommandBus as Tactician;

final class CommandBus
{
    /**
     * @var Tactician
     */
    private $commandBus;

    /**
     * CommandBus constructor.
     * @param array $middlewares
     */
    public function __construct(array $middlewares)
    {
        $this->commandBus = new Tactician($middlewares);
    }

    /**
     * @param MessageInterface $command
     * @return $this
     */
    public function handle(MessageInterface $command)
    {
        $this->commandBus->handle($command);

        return $this;
    }

    /**
     * @param MessageInterface $command
     */
    public function __invoke(MessageInterface $command)
    {
        $this->handle($command);
    }
}
