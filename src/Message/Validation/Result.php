<?php
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
        return (count($this->errors) === 0);
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
