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
     * @return array
     */
    public function data(): array;

    /**
     * @return array
     */
    public function metadata(): array;

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
     * @return array
     */
    public function handlers(): array;

    /**
     * @return Result
     */
    public function validate(): Result;
}
