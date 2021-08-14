<?php

namespace Jakmall\Recruitment\Calculator\Commands\Calculations;

use Exception;
use Jakmall\Recruitment\Calculator\Commands\Interfaces\CommandsInterface;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class PowerCalculation implements CommandsInterface
{
    public function calculate($number1, $number2)
    {
        return pow($number1, $number2);
    }

    public function calculateAll(array $numbers)
    {
        if (count($numbers) > 2) {
            throw new Exception(Constant::POWER_EXCEPTION_MESSAGE);
        }

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
