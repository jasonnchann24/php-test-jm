<?php

declare(strict_types=1);

use Jakmall\Recruitment\Calculator\Commands\DivideCommand;
use Jakmall\Recruitment\Calculator\Utils\Constant;
use Jakmall\Recruitment\Calculator\Utils\TestTrait;
use PHPUnit\Framework\TestCase;

final class DivideCommandTest extends TestCase
{
    use TestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->classToTest = DivideCommand::class;
        $this->makeConsole();
    }

    public function testDivideCommand()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'numbers' => [10, 5, 2]
        ]);

        $this->assertEquals('10 / 5 / 2 = 1', rtrim($this->commandTester->getDisplay()));
    }

    public function testZeroDivision()
    {
        $this->expectErrorMessage(Constant::ZERO_DIVISION_MESSAGE);

        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'numbers' => [10, 0]
        ]);
    }
}
