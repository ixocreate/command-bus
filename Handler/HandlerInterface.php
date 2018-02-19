<?php
namespace KiwiSuite\CommandBus\Handler;

use KiwiSuite\CommandBus\Message\MessageInterface;

interface HandlerInterface
{
    public static function getMessageName(): string;

    public function __invoke(MessageInterface $message);
}
