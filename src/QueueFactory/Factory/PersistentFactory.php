<?php
namespace KiwiSuite\CommandBus\QueueFactory\Factory;

use Bernard\Driver\DoctrineDriver;
use Bernard\Normalizer\EnvelopeNormalizer;
use Bernard\Serializer;
use KiwiSuite\CommandBus\Message\MessageNormalizer;
use KiwiSuite\CommandBus\Message\QueueMessageNormalizer;
use KiwiSuite\Database\Connection\Factory\ConnectionSubManager;
use KiwiSuite\ServiceManager\FactoryInterface;
use KiwiSuite\ServiceManager\ServiceManagerInterface;
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
            new QueueMessageNormalizer(),
            new MessageNormalizer()
        ]);

        return new \KiwiSuite\CommandBus\QueueFactory\PersistentFactory(
            new DoctrineDriver($container->get(ConnectionSubManager::class)->get('master')),
            new Serializer($aggregateNormalizer)
        );
    }
}
