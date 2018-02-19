<?php
namespace KiwiSuite\CommandBus\Message;

use DateTimeImmutable;
use KiwiSuite\CommonTypes\Entity\DateTimeType;
use KiwiSuite\CommonTypes\Entity\UuidType;
use KiwiSuite\Entity\Type\Type;
use Ramsey\Uuid\Uuid;

abstract class AbstractMessage implements MessageInterface
{

    /**
     * @var mixed
     */
    private $payload;

    /**
     * @var UuidType
     */
    private $uuid;

    /**
     * @var DateTimeType
     */
    private $createdAt;

    /**
     * @var array
     */
    private $metadata;

    /**
     * AbstractMessage constructor.
     * @param $payload
     * @param array $metadata
     * @param UuidType|null $uuid
     * @param DateTimeType|null $createdAt
     */
    public function __construct(
        $payload,
        array $metadata = [],
        UuidType $uuid = null,
        DateTimeType $createdAt = null
    ) {
        $this->payload = $payload;
        $this->metadata = $metadata;

        if ($uuid === null) {
            $uuid = Type::create(Uuid::uuid4()->toString(), UuidType::class);
        }
        $this->uuid = $uuid;

        if ($createdAt === null) {
            $createdAt = Type::create(new DateTimeImmutable(), DateTimeType::class);
        }
        $this->createdAt = $createdAt;
    }

    /**
     * @return UuidType
     */
    public function uuid(): UuidType
    {
        return $this->uuid;
    }

    /**
     * @return DateTimeType
     */
    public function createdAt(): DateTimeType
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function payload()
    {
        return $this->payload;
    }

    /**
     * @return array
     */
    public function metadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     * @return MessageInterface
     */
    public function withMetadata(array $metadata): MessageInterface
    {
        return new static(
            $this->payload,
            $metadata,
            $this->uuid,
            $this->createdAt
        );
    }

    /**
     * @param string $key
     * @param $value
     * @return MessageInterface
     */
    public function withAddedMetadata(string $key, $value): MessageInterface
    {
        $metadata = $this->metadata;
        $metadata[$key] = $value;

        return $this->withMetadata($metadata);
    }

    /**
     * @return array|mixed
     */
    final public function jsonSerialize()
    {
        return [
            'className' => \get_class($this),
            'uuid' => $this->uuid()->getValue(),
            'createdAt' => $this->createdAt()->getValue()->getTimestamp(),
            'payload' => $this->payload(),
            'metadata' => $this->metadata(),
        ];
    }
}
