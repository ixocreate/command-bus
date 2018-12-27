<?php
/**
 * kiwi-suite/command-bus (https://github.com/kiwi-suite/command-bus)
 *
 * @package kiwi-suite/command-bus
 * @link https://github.com/kiwi-suite/command-bus
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace Ixocreate\CommandBus;

use Ixocreate\Contract\Application\SerializableServiceInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Config implements SerializableServiceInterface
{
    private $config = [];

    public function __construct(array $config)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'handlers' => [],
        ]);
        $resolver->setAllowedTypes('handlers', 'string[]');

        $this->config = $resolver->resolve($config);
    }

    public function handlers(): array
    {
        return $this->config['handlers'];
    }

    /**
     * @return string|void
     */
    public function serialize()
    {
        return \serialize($this->config);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->config = \unserialize($serialized);
    }
}
