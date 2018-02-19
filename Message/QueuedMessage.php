<?php

namespace KiwiSuite\CommandBus\Message;

use Bernard\Message;

/**
 * Indicates the command has been queued or not
 */
final class QueuedMessage implements Message
{
    /**
     * @var Message
     */
    private $message;

    /**
     * @param QueueableMessageInterface $message
     */
    public function __construct(QueueableMessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * Returns the wrapped command
     *
     * @return Message
     */
    public function getCommand()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->message->getName();
    }
}
