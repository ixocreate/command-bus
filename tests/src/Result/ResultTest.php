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
namespace IxocreateTest\CommandBus\Result;

use Ixocreate\CommandBus\Result\Result;
use Ixocreate\Contract\CommandBus\CommandInterface;
use Ixocreate\Contract\CommandBus\ResultInterface;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    /**
     * @covers \Ixocreate\CommandBus\Result\Result::command
     * @covers \Ixocreate\CommandBus\Result\Result::isSuccessful
     * @covers \Ixocreate\CommandBus\Result\Result::status
     * @covers \Ixocreate\CommandBus\Result\Result::messages
     * @covers \Ixocreate\CommandBus\Result\Result::__construct
     */
    public function testResult()
    {
        $command = $this->createMock(CommandInterface::class);

        $result = new Result(ResultInterface::STATUS_DONE, $command, ['input' => 'test']);
        $this->assertTrue($result->isSuccessful());
        $this->assertSame(ResultInterface::STATUS_DONE, $result->status());
        $this->assertSame($command, $result->command());
        $this->assertSame(['input' => 'test'], $result->messages());

        $result = new Result(ResultInterface::STATUS_ERROR, $command, ['input' => 'test']);
        $this->assertFalse($result->isSuccessful());
    }
}
