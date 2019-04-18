<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\CommandBus\Command;

use Ixocreate\CommandBus\Command\AbstractCommand;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AbstractCommandTest extends TestCase
{
    private $command;

    public function setUp()
    {
        $this->command = $this->getMockForAbstractClass(AbstractCommand::class);
    }

    /**
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::uuid
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::withUuid
     */
    public function testUuid()
    {
        $uuid = Uuid::uuid4()->toString();
        $command = $this->command->withUuid($uuid);
        $this->assertSame($uuid, $command->uuid());
    }

    /**
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::uuid
     */
    public function testUuidDefault()
    {
        $uuid = $this->command->uuid();

        $this->assertTrue(Uuid::isValid($uuid));
    }

    /**
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::createdAt
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::withCreatedAt
     */
    public function testCreatedAt()
    {
        $createdAt = new \DateTimeImmutable();
        $command = $this->command->withCreatedAt($createdAt);
        $this->assertSame($createdAt, $command->createdAt());

        $createdAt = new \DateTime();
        $command = $this->command->withCreatedAt($createdAt);
        $this->assertNotSame($createdAt, $command->createdAt());
        $this->assertInstanceOf(\DateTimeInterface::class, $command->createdAt());
    }

    /**
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::createdAt
     */
    public function testCreatedAtDefault()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->command->createdAt());
    }

    /**
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::data
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::withData
     */
    public function testData()
    {
        $command = $this->command->withData(['test']);
        $this->assertSame(['test'], $command->data());
    }

    /**
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::data
     */
    public function testDataDefault()
    {
        $this->assertSame([], $this->command->data());
    }

    /**
     * @covers \Ixocreate\CommandBus\Command\AbstractCommand::dataValue
     */
    public function testDataValue()
    {
        $command = $this->command->withData(['test' => 'test', 'abc' => 'xyz']);

        $this->assertSame(null, $command->dataValue('nothing'));
        $this->assertSame('something', $command->dataValue('nothing', 'something'));
        $this->assertSame('xyz', $command->dataValue('abc'));
    }
}
