<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Commands\Calculations\MultiplyCalculation;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class MultiplyCommand extends BaseCommand
{
    protected $verb = Constant::MULTIPLY;
    protected $operator = '*';
    protected $calculation;

    public function __construct(MultiplyCalculation $calculation)
    {
        $this->calculation = $calculation;

        parent::__construct();
    }
}
