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
namespace KiwiSuiteTest\CommandBus\Result;

use KiwiSuite\CommandBus\Result\Result;
use KiwiSuite\Contract\CommandBus\CommandInterface;
use KiwiSuite\Contract\CommandBus\ResultInterface;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    /**
     * @covers \KiwiSuite\CommandBus\Result\Result::command
     * @covers \KiwiSuite\CommandBus\Result\Result::isSuccessful
     * @covers \KiwiSuite\CommandBus\Result\Result::status
     * @covers \KiwiSuite\CommandBus\Result\Result::messages
     * @covers \KiwiSuite\CommandBus\Result\Result::__construct
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
