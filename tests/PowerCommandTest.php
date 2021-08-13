<?php

declare(strict_types=1);

use Jakmall\Recruitment\Calculator\Commands\PowerCommand;
use Jakmall\Recruitment\Calculator\Utils\Constant;
use Jakmall\Recruitment\Calculator\Utils\TestTrait;
use PHPUnit\Framework\TestCase;

final class PowerCommandTest extends TestCase
{
    use TestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->classToTest = PowerCommand::class;
        $this->makeConsole();
    }

    public function testPowerCommand()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'numbers' => [2, 3]
        ]);

        $this->assertEquals('2 ^ 3 = 8', rtrim($this->commandTester->getDisplay()));
    }

    public function testMoreThanTwoArguments()
    {
        // $this->expectException('exception');
        $this->expectErrorMessage(Constant::POWER_EXCEPTION_MESSAGE);

        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'numbers' => [10, 2, 3]
        ]);
    }
}
