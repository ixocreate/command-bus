<?php
namespace KiwiSuite\CommandBus\Handler;

use KiwiSuite\CommandBus\Message\MessageInterface;

interface HandlerInterface
{
    public function __invoke(MessageInterface $message): MessageInterface;
}
