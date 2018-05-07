<?php
namespace KiwiSuite\CommandBus;

/** @var ConsoleConfigurator $console */
use KiwiSuite\ApplicationConsole\ConsoleConfigurator;
use KiwiSuite\CommandBus\Console\ConsumeCommand;

$console->addCommand(ConsumeCommand::class);

