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
namespace KiwiSuite\CommandBus\Command;

use KiwiSuite\Contract\CommandBus\CommandInterface;
use Ramsey\Uuid\Uuid;

abstract class AbstractCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @var array
     */
    private $data;

    /**
     * @throws \Exception
     * @return string
     */
    public function uuid(): string
    {
        if (empty($this->uuid)) {
            $this->uuid = Uuid::uuid4()->toString();
        }

        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return CommandInterface
     */
    public function withUuid(string $uuid): CommandInterface
    {
        $command = clone $this;
        $command->uuid = $uuid;

        return $command;
    }

    /**
     * @throws \Exception
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTimeImmutable();
        }

        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return CommandInterface
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): CommandInterface
    {
        $command = clone $this;
        if (!($createdAt instanceof \DateTimeImmutable)) {
            $createdAt = clone $createdAt;
        }

        $command->createdAt = $createdAt;

        return $command;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        if ($this->data === null) {
            $this->data = [];
        }

        return $this->data;
    }

    /**
     * @param array $data
     * @return CommandInterface
     */
    public function withData(array $data): CommandInterface
    {
        $command = clone $this;
        $command->data = $data;

        return $command;
    }
}