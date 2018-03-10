<?php
namespace KiwiSuite\CommandBus\Message;

use Bernard\Message;
use KiwiSuite\CommandBus\Message\Validation\Result;
use KiwiSuite\CommonTypes\Entity\DateTimeType;
use KiwiSuite\CommonTypes\Entity\UuidType;

final class QueuedMessage implements Message, MessageInterface
{
    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * QueuedMessage constructor.
     * @param MessageInterface $message
     */
    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * @return MessageInterface
     */
    public function getMessage(): MessageInterface
    {
        return $this->getMessage();
    }

    /**
     * @return bool|string
     */
    public function getName()
    {
        $className = \get_class($this->message);
        return substr($className, strrpos($className, '\\') + 1);
    }

    /**
     * @return UuidType
     */
    public function uuid(): UuidType
    {
        return $this->message->uuid();
    }

    /**
     * @return DateTimeType
     */
    public function createdAt(): DateTimeType
    {
        return $this->message->createdAt();
    }

    /**
     * @param array $data
     * @param array $metadata
     * @param UuidType|null $uuid
     * @param DateTimeType|null $createdAt
     * @return MessageInterface
     */
    public function inject(array $data, array $metadata, UuidType $uuid = null, DateTimeType $createdAt = null): MessageInterface
    {
        //TODO Exception
    }

    /**
     * @return bool
     */
    public function isInjected(): bool
    {
        return $this->message->isInjected();
    }

    /**
     * @return string
     */
    public static function getHandler(): string
    {
        //TODO Exception
    }

    /**
     * @return Result
     */
    public function validate(): Result
    {
        return $this->message->validate();
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->message->jsonSerialize();
    }
}
