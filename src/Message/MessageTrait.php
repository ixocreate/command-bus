<?php
namespace KiwiSuite\CommandBus\Message;

use KiwiSuite\CommandBus\Message\Validation\Result;
use KiwiSuite\CommonTypes\Entity\DateTimeType;
use KiwiSuite\CommonTypes\Entity\UuidType;
use KiwiSuite\Entity\Type\Type;
use Ramsey\Uuid\Uuid;

trait MessageTrait
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $metadata;

    /**
     * @var UuidType
     */
    private $uuid;

    /**
     * @var DateTimeType
     */
    private $createdAt;


    /**
     * @param array $data
     * @param array $metadata
     * @param UuidType|null $uuid
     * @param DateTimeType|null $createdAt
     * @return MessageInterface
     */
    public function inject(array $data, array $metadata = [], UuidType $uuid = null, DateTimeType $createdAt = null): MessageInterface
    {
        if ($this->isInjected()) {
            //TODO Exception
        }

        $message = clone $this;

        $message->data = $data;
        $message->metadata = $metadata;

        if ($uuid === null) {
            $uuid = Type::create(Uuid::uuid4()->toString(), UuidType::class);
        }
        $message->uuid = $uuid;

        if ($createdAt === null) {
            $createdAt = Type::create(new \DateTimeImmutable(), DateTimeType::class);
        }
        $message->createdAt = $createdAt;

        return $message;
    }

    /**
     * @return bool
     */
    public function isInjected(): bool
    {
        return (($this->data !== null) && ($this->uuid instanceof UuidType) && ($this->createdAt instanceof DateTimeType));
    }

    /**
     * @return Result
     */
    public function validate(): Result
    {
        if (!$this->isInjected()) {
            //TODO Exception
        }

        $result = new Result();

        $this->doValidate($result);

        return $result;
    }

    public function __clone()
    {
        $this->data = null;
        $this->metadata = null;
        $this->uuid = null;
        $this->createdAt = null;
    }

    /**
     * @param Result $result
     */
    abstract protected function doValidate(Result $result): void;

    /**
     * @return UuidType
     */
    public function uuid(): UuidType
    {
        if (!$this->isInjected()) {
            //TODO Exception
        }

        return $this->uuid;
    }

    /**
     * @return DateTimeType
     */
    public function createdAt(): DateTimeType
    {
        if (!$this->isInjected()) {
            //TODO Exception
        }

        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function metadata(): array
    {
        return $this->metadata;
    }

    public function jsonSerialize()
    {
        return [
            'className' => \get_class($this),
            'data' => $this->data,
            'metadata' => $this->metadata,
            'uuid' => $this->uuid()->getValue(),
            'createdAt' => $this->createdAt()->getValue()->getTimestamp()
        ];
    }
}

