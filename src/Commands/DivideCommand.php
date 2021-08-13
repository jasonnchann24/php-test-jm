<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Exception;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class DivideCommand extends BaseCommand
{
    protected $verb = 'divide';
    protected $operator = '/';

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        if ($number2 == 0) {
            throw new Exception(Constant::ZERO_DIVISION_MESSAGE);
        }

        return $number1 / $number2;
    }
}
