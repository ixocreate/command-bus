<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus;

use Ixocreate\ServiceManager\NamedServiceInterface;

interface CommandInterface extends NamedServiceInterface
{
    /**
     * @return bool
     */
    public function execute(): bool;

    /**
     * @return string
     */
    public function uuid(): string;

    /**
     * @param string $uuid
     * @return CommandInterface
     */
    public function withUuid(string $uuid): self;

    /**
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface;

    /**
     * @param \DateTimeInterface $createdAt
     * @return CommandInterface
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self;

    /**
     * @return array
     */
    public function data(): array;

    /**
     * @param array $data
     * @return CommandInterface
     */
    public function withData(array $data): self;

    /**
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public function dataValue(string $name, $default = null);
}
