<?php
namespace KiwiSuite\CommandBus\Message;


abstract class AbstractQueueableMessage extends AbstractMessage implements QueueableMessageInterface
{
    public function getName()
    {
        $className = \get_class($this);
        return substr($className, strrpos($className, '\\') + 1);
    }
}
