<?php
/**
 * kiwi-suite/command-bus (https://github.com/kiwi-suite/command-bus)
 *
 * @package kiwi-suite/command-bus
 * @link https://github.com/kiwi-suite/command-bus
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuiteTest\CommandBus\Command;

use KiwiSuite\CommandBus\Command\AbstractCommand;
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
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::uuid
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::withUuid
     */
    public function testUuid()
    {
        $uuid = Uuid::uuid4()->toString();
        $command = $this->command->withUuid($uuid);
        $this->assertSame($uuid, $command->uuid());
    }

    /**
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::uuid
     */
    public function testUuidDefault()
    {
        $uuid = $this->command->uuid();

        $this->assertTrue(Uuid::isValid($uuid));
    }

    /**
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::createdAt
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::withCreatedAt
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
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::createdAt
     */
    public function testCreatedAtDefault()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->command->createdAt());
    }

    /**
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::data
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::withData
     */
    public function testData()
    {
        $command = $this->command->withData(['test']);
        $this->assertSame(['test'], $command->data());
    }

    /**
     * @covers \KiwiSuite\CommandBus\Command\AbstractCommand::data
     */
    public function testDataDefault()
    {
        $this->assertSame([], $this->command->data());
    }
}
