<?php

declare(strict_types=1);

use Jakmall\Recruitment\Calculator\Commands\MultiplyCommand;
use Jakmall\Recruitment\Calculator\Utils\TestTrait;
use PHPUnit\Framework\TestCase;

final class MultiplyCommandTest extends TestCase
{
    use TestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->classToTest = MultiplyCommand::class;
        $this->makeConsole();
    }

    public function testMultiplyCommand()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'numbers' => [1, 2, 3]
        ]);

        $this->assertEquals('1 * 2 * 3 = 6', rtrim($this->commandTester->getDisplay()));
    }
}
