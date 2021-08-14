<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Commands\Calculations\AddCalculation;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class AddCommand extends BaseCommand
{
    protected $verb = Constant::ADD;
    protected $operator = '+';
    protected $calculation;

    public function __construct(AddCalculation $calculation)
    {
        $this->calculation = $calculation;

        parent::__construct();
    }
}
