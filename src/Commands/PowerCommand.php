<?php

namespace Jakmall\Recruitment\Calculator\Commands;

class PowerCommand extends BaseCommand
{
    protected $verb = 'power';
    protected $operator = '^';

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return pow($number1, $number2);
    }
}
