<?php
namespace KiwiSuite\CommandBus\Handler;

use KiwiSuite\ServiceManager\ServiceManagerConfig;

final class HandlerServiceManagerConfig extends ServiceManagerConfig
{
    /**
     * @var array
     */
    private $handlerMap = [];

    /**
     * HandlerServiceManagerConfig constructor.
     * @param array $handlerMap
     * @param array $factories
     * @param array $subManagers
     * @param array $delegators
     * @param array $lazyServices
     * @param array $disabledSharing
     * @param array $initializers
     */
    public function __construct(array $handlerMap = [], array $factories = [], array $subManagers = [], array $delegators = [], array $lazyServices = [], array $disabledSharing = [], array $initializers = [])
    {
        $this->handlerMap = $handlerMap;

        parent::__construct($factories, $subManagers, $delegators, $lazyServices, $disabledSharing, $initializers);
    }

    /**
     * @return array
     */
    public function getHandlerMap(): array
    {
        return $this->handlerMap;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return \serialize([
            'handlerMap' => $this->handlerMap,
            'config' => $this->getInternalConfig(),
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = \unserialize($serialized);

        $this->handlerMap = $data['handlerMap'];
        $this->setInternalConfig($data['config']);
    }
}
