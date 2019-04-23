<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\CommandBus\Result;

use Ixocreate\CommandBus\Command\CommandInterface;

interface ResultInterface
{
    public const STATUS_DONE = 'done';

    public const STATUS_ERROR = 'error';

    /**
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * @return string
     */
    public function status(): string;

    /**
     * @return CommandInterface
     */
    public function command(): CommandInterface;

    /**
     * @return string[]
     */
    public function messages(): array;
}
