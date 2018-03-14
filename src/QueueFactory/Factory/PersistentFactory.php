<?php
namespace KiwiSuite\CommandBus\QueueFactory\Factory;

use Bernard\Driver\DoctrineDriver;
use Bernard\Normalizer\EnvelopeNormalizer;
use Bernard\Serializer;
use KiwiSuite\CommandBus\Message\MessageSubManager;
use KiwiSuite\CommandBus\Message\Normalizer\MessageNormalizer;
use KiwiSuite\CommandBus\Message\Normalizer\QueuedMessageNormalizer;
use KiwiSuite\Contract\ServiceManager\FactoryInterface;
use KiwiSuite\Contract\ServiceManager\ServiceManagerInterface;
use KiwiSuite\Database\Connection\Factory\ConnectionSubManager;
use Normalt\Normalizer\AggregateNormalizer;

final class PersistentFactory implements FactoryInterface
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
        $aggregateNormalizer = new AggregateNormalizer([
            new EnvelopeNormalizer(),
            new QueuedMessageNormalizer(),
            new MessageNormalizer($container->get(MessageSubManager::class))
        ]);

        return new \KiwiSuite\CommandBus\QueueFactory\PersistentFactory(
            new DoctrineDriver($container->get(ConnectionSubManager::class)->get('master')),
            new Serializer($aggregateNormalizer)
        );
    }
}
