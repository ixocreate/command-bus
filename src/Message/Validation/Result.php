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
namespace KiwiSuite\CommandBus\Message\Validation;

final class Result
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return \count($this->errors) === 0;
    }

    /**
     * @param $error
     */
    public function addError($error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
