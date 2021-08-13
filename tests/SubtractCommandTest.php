<?php

declare(strict_types=1);

use Jakmall\Recruitment\Calculator\Commands\SubtractCommand;
use Jakmall\Recruitment\Calculator\Utils\TestTrait;
use PHPUnit\Framework\TestCase;

final class SubtractCommandTest extends TestCase
{
    use TestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->classToTest = SubtractCommand::class;
        $this->makeConsole();
    }

    public function testSubtractCommand()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'numbers' => [1, 2, 3]
        ]);

        $this->assertEquals('1 - 2 - 3 = -4', rtrim($this->commandTester->getDisplay()));
    }
}
