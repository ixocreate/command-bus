<?php
namespace KiwiSuite\CommandBus\Message;

use KiwiSuite\CommandBus\Message\Validation\Result;
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
     * @param array $data
     * @param array $metadata
     * @param UuidType|null $uuid
     * @param DateTimeType|null $createdAt
     * @return MessageInterface
     */
    public function inject(array $data, array $metadata, UuidType $uuid = null, DateTimeType $createdAt = null): MessageInterface;

    /**
     * @return bool
     */
    public function isInjected(): bool;

    /**
     * @return string
     */
    public static function getHandler(): string;

    /**
     * @return Result
     */
    public function validate(): Result;

    /**
     * @return bool
     */
    public function isValidated(): bool;
}
