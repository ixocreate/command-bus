<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus;

use Ixocreate\Application\Service\SerializableServiceInterface;
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
