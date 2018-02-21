<?php
namespace KiwiSuite\CommandBus\Factory;

use Bernard\Producer;
use KiwiSuite\CommandBus\CommandBus;
use KiwiSuite\CommandBus\Handler\HandlerServiceManagerConfig;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\CommandBus\Middleware\QueueMiddleware;
use KiwiSuite\CommandBus\Middleware\TransformQueueMiddleware;
use KiwiSuite\CommandBus\QueueFactory\PersistentFactory;
use KiwiSuite\Database\Connection\Factory\ConnectionSubManager;
use KiwiSuite\ServiceManager\FactoryInterface;
use KiwiSuite\ServiceManager\ServiceManagerInterface;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class CommandBusFactory implements FactoryInterface
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
        $middlewares = [];
        if ($container->has(ConnectionSubManager::class)) {
            $middlewares[] = new TransformQueueMiddleware();
            $middlewares[] = $this->getQueueMiddleware($container);
        }

        $middlewares[] = $this->getCommandHandlerMiddleware($container);

        return new CommandBus($middlewares);
    }

    /**
     * @param ServiceManagerInterface $container
     * @return CommandHandlerMiddleware
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getCommandHandlerMiddleware(ServiceManagerInterface $container): CommandHandlerMiddleware
    {
        /** @var HandlerServiceManagerConfig $handlerServiceManagerConfig */
        $handlerServiceManagerConfig = $container->get(HandlerServiceManagerConfig::class);

        $locator = new ContainerLocator(
            $container->get(HandlerSubManager::class),
            $handlerServiceManagerConfig->getHandlerMap()

        );

        return new CommandHandlerMiddleware(
            new ClassNameExtractor(),
            $locator,
            new InvokeInflector()
        );
    }

    /**
     * @param ServiceManagerInterface $container
     * @return QueueMiddleware
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getQueueMiddleware(ServiceManagerInterface $container): QueueMiddleware
    {
        $producer = new Producer(
            $container->get(PersistentFactory::class),
            new EventDispatcher()
        );

        return new QueueMiddleware($producer);
    }
}
