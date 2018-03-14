<?php
/**
 * kiwi-suite/command-bus (https://github.com/kiwi-suite/command-bus)
 *
 * @package kiwi-suite/command-bus
 * @see https://github.com/kiwi-suite/command-bus
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuite\CommandBus\Consumer\Factory;

use Bernard\Router\ClassNameRouter;
use KiwiSuite\CommandBus\CommandBus;
use KiwiSuite\CommandBus\Consumer\Consumer;
use KiwiSuite\CommandBus\Message\QueuedMessage;
use KiwiSuite\Contract\ServiceManager\FactoryInterface;
use KiwiSuite\Contract\ServiceManager\ServiceManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class ConsumerFactory implements FactoryInterface
{

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @return mixed
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null)
    {
        $router = new ClassNameRouter([
            QueuedMessage::class => $container->get(CommandBus::class),
        ]);

        return new Consumer($router, new EventDispatcher());
    }
}
