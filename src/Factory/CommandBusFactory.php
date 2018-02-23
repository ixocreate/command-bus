<?php
namespace KiwiSuite\CommandBus\Factory;

use KiwiSuite\CommandBus\CommandBus;
use KiwiSuite\CommandBus\Handler\HandlerSubManager;
use KiwiSuite\CommandBus\Message\MessageServiceManagerConfig;
use KiwiSuite\CommandBus\Plugin\TransformPlugin;
use KiwiSuite\CommandBus\Plugin\ValidationPlugin;
use KiwiSuite\ServiceManager\FactoryInterface;
use KiwiSuite\ServiceManager\ServiceManagerInterface;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;

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
        $middlewares = [
            new TransformPlugin(),
            new ValidationPlugin()
        ];

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
        /** @var MessageServiceManagerConfig $messageServiceManagerConfig */
        $messageServiceManagerConfig = $container->get(MessageServiceManagerConfig::class);

        $locator = new ContainerLocator(
            $container->get(HandlerSubManager::class),
            $messageServiceManagerConfig->getHandlerMap()
        );

        return new CommandHandlerMiddleware(
            new ClassNameExtractor(),
            $locator,
            new InvokeInflector()
        );
    }
}
