<?php

namespace Jakmall\Recruitment\Calculator\Commands;

class AddCommand extends BaseCommand
{
    protected $verb = 'add';
    protected $operator = '+';

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 + $number2;
    }
}
