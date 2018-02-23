<?php
namespace KiwiSuite\CommandBus\ConfiguratorItem;

use KiwiSuite\Application\ConfiguratorItem\ConfiguratorItemInterface;
use KiwiSuite\CommandBus\Message\MessageInterface;
use KiwiSuite\CommandBus\Message\MessageServiceManagerConfig;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

final class MessageConfiguratorItem implements ConfiguratorItemInterface
{

    /**
     * @return mixed
     */
    public function getConfigurator()
    {
        return new ServiceManagerConfigurator();
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return 'messageConfigurator';
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return 'message.php';
    }

    /**
     * @param $configurator
     * @return \Serializable
     */
    public function getService($configurator): \Serializable
    {
        $config = $configurator->getServiceManagerConfig();

        $handlerMap = [];
        foreach ($config->getFactories() as $id => $factory) {
            if (!\class_exists($id)) {
                throw new \InvalidArgumentException(\sprintf("'%s' can't load", $id));

            }
            if (!\is_subclass_of($id, MessageInterface::class, true)) {
                throw new \InvalidArgumentException(\sprintf("'%s' doesn't implement '%s'", $id, MessageInterface::class));
            }
            $handler = \forward_static_call([$id, 'getHandler']);
            $handlerMap[$id] = $handler;
        }

        return new MessageServiceManagerConfig(
            $handlerMap,
            $config->getFactories(),
            $config->getSubManagers(),
            $config->getDelegators(),
            $config->getLazyServices(),
            $config->getDisabledSharing(),
            $config->getInitializers()
        );
    }
}
