<?php

namespace Jakmall\Recruitment\Calculator\Commands\Calculations;

use Exception;

class CalculationFactory
{
    public function create(string $type)
    {
        switch ($type) {
            case 'add':
                return new AddCalculation();
            case 'subtract':
                return new SubtractCalculation();
            case 'multiply':
                return new MultiplyCalculation();
            case 'power':
                return new PowerCalculation();
            case 'divide':
                return new DivideCalculation();
        }

        throw new Exception("Calculation not found");
    }
}
