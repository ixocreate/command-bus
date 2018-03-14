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
namespace KiwiSuite\CommandBus\Message\Normalizer;

use Assert\Assertion;
use Bernard\Normalizer\AbstractAggregateNormalizerAware;
use KiwiSuite\CommandBus\Message\QueuedMessage;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class QueuedMessageNormalizer extends AbstractAggregateNormalizerAware implements NormalizerInterface, DenormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'class' => \get_class($object->getMessage()),
            'name' => $object->getName(),
            'data' => $this->aggregate->normalize($object->getMessage()),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof QueuedMessage;
    }
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        Assertion::choicesNotEmpty($data, ['class', 'name', 'data']);
        Assertion::classExists($data['class']);
        $object = new QueuedMessage(
            $this->aggregate->denormalize($data['data'], $data['class'])
        );
        return $object;
    }
    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === QueuedMessage::class;
    }
}
