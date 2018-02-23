<?php
namespace KiwiSuite\CommandBus\Message\Normalizer;

use KiwiSuite\CommandBus\Message\MessageInterface;
use KiwiSuite\CommandBus\Message\MessageSubManager;
use KiwiSuite\CommonTypes\Entity\DateTimeType;
use KiwiSuite\CommonTypes\Entity\UuidType;
use KiwiSuite\Entity\Type\Type;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class MessageNormalizer implements NormalizerInterface, DenormalizerInterface
{

    /**
     * @var MessageSubManager
     */
    private $messageSubManager;

    /**
     * MessageNormalizer constructor.
     * @param MessageSubManager $messageSubManager
     */
    public function __construct(MessageSubManager $messageSubManager)
    {
        $this->messageSubManager = $messageSubManager;
    }

    /**
     * @param mixed $data
     * @param string $class
     * @param null $format
     * @param array $context
     * @return mixed|object
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $message = $this->messageSubManager->build($data['className']);
        $message = $message->inject(
            $data['data'],
            $data['metadata'],
            Type::create($data['uuid'], UuidType::class),
            Type::create($data['createdAt'], DateTimeType::class)
        );

        return $message;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param null $format
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return (!empty($data['className']) && class_exists($data['className']) && in_array(MessageInterface::class, class_implements($data['className'])));
    }

    /**
     * @param object $object
     * @param null $format
     * @param array $context
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return $object->jsonSerialize();
    }

    /**
     * @param mixed $data
     * @param null $format
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return ($data instanceof MessageInterface);
    }
}
