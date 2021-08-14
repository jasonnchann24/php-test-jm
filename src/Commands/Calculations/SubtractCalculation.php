<?php

namespace Jakmall\Recruitment\Calculator\Commands\Calculations;

use Jakmall\Recruitment\Calculator\Commands\Interfaces\CommandsInterface;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class SubtractCalculation implements CommandsInterface
{
    public function calculate($number1, $number2)
    {
        return $number1 - $number2;
    }

    public function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }

    public function saveToLog($verb, $description, $result, $driver, CommandHistoryManagerInterface $history)
    {
        $history->log([
            'verb' => $verb,
            'description' => $description,
            'result' => $result,
            'driver' => $driver
        ]);
    }
}
