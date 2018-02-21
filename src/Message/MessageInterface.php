<?php
namespace KiwiSuite\CommandBus\Message;

use KiwiSuite\CommonTypes\Entity\DateTimeType;
use KiwiSuite\CommonTypes\Entity\UuidType;

interface MessageInterface extends \JsonSerializable
{
    /**
     * @return UuidType
     */
    public function uuid(): UuidType;

    /**
     * @return DateTimeType
     */
    public function createdAt(): DateTimeType;

    /**
     * @return mixed
     */
    public function payload();

    /**
     * @return array
     */
    public function metadata(): array;

    /**
     * @param array $metadata
     * @return MessageInterface
     */
    public function withMetadata(array $metadata): MessageInterface;

    /**
     * @param string $key
     * @param $value
     * @return self
     */
    public function withAddedMetadata(string $key, $value): MessageInterface;
}
