<?php
namespace KiwiSuite\CommandBus\ConfiguratorItem;

use KiwiSuite\Application\ConfiguratorItem\ConfiguratorItemInterface;
use KiwiSuite\CommandBus\Handler\HandlerInterface;
use KiwiSuite\CommandBus\Handler\HandlerServiceManagerConfig;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

final class HandlerConfiguratorItem implements ConfiguratorItemInterface
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
        return 'handlerConfigurator';
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return 'handler.php';
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
            if (!\is_subclass_of($id, HandlerInterface::class, true)) {
                throw new \InvalidArgumentException(\sprintf("'%s' doesn't implement '%s'", $id, HandlerInterface::class));
            }
            $messageName = \forward_static_call([$id, 'getMessageName']);
            $handlerMap[$messageName] = $id;
        }

        return new HandlerServiceManagerConfig(
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
