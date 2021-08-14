<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Commands\Calculations\PowerCalculation;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class PowerCommand extends BaseCommand
{
    protected $verb = Constant::POWER;
    protected $operator = '^';
    protected $calculation;

    public function __construct(PowerCalculation $calculation)
    {
        $this->calculation = $calculation;

        parent::__construct();
    }
}
