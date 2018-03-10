<?php
namespace KiwiSuite\CommandBus\ConfiguratorItem;

use KiwiSuite\Application\ConfiguratorItem\ConfiguratorItemInterface;
use KiwiSuite\CommandBus\Message\MessageServiceManagerConfig;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

final class MessageConfiguratorItem implements ConfiguratorItemInterface
{

    /**
     * @return mixed
     */
    public function getConfigurator()
    {
        return new ServiceManagerConfigurator(MessageServiceManagerConfig::class);
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
        return $configurator->getServiceManagerConfig();
    }
}
