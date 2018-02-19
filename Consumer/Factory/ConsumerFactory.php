<?php
namespace KiwiSuite\CommandBus\Consumer\Factory;

use Bernard\Router\ClassNameRouter;
use Bernard\Router\SimpleRouter;
use KiwiSuite\CommandBus\CommandBus;
use KiwiSuite\CommandBus\Consumer\Consumer;
use KiwiSuite\CommandBus\Message\QueuedMessage;
use KiwiSuite\ServiceManager\FactoryInterface;
use KiwiSuite\ServiceManager\ServiceManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class ConsumerFactory implements FactoryInterface
{

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null)
    {
        $router = new ClassNameRouter([
            QueuedMessage::class => $container->get(CommandBus::class)
        ]);

        return new Consumer($router, new EventDispatcher());
    }
}
