<?php

declare(strict_types=1);

use Jakmall\Recruitment\Calculator\Commands\AddCommand;
use Jakmall\Recruitment\Calculator\Utils\TestTrait;
use PHPUnit\Framework\TestCase;

final class AddCommandTest extends TestCase
{
    use TestTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->classToTest = AddCommand::class;
        $this->makeConsole();
    }

    public function testAddCommand()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'numbers' => [1, 2, 3]
        ]);

        $this->assertEquals('1 + 2 + 3 = 6', rtrim($this->commandTester->getDisplay()));
    }
}
