<?php

namespace Jakmall\Recruitment\Calculator\Commands\Interfaces;

use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

interface CommandsInterface
{
    public function calculate($x, $y);
    public function calculateAll(array $numbers);
    public function saveToLog($verb, $description, $result, $driver, CommandHistoryManagerInterface $history);
}
