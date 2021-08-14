<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Commands\Calculations\SubtractCalculation;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class SubtractCommand extends BaseCommand
{
    protected $verb = Constant::SUBTRACT;
    protected $operator = '-';
    protected $calculation;

    public function __construct(SubtractCalculation $calculation)
    {
        $this->calculation = $calculation;

        parent::__construct();
    }
}
