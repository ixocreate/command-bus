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

    public function addError():void
    {

    }
}
