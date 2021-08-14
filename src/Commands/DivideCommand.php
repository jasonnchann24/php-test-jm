<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Exception;
use Jakmall\Recruitment\Calculator\Commands\Calculations\DivideCalculation;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class DivideCommand extends BaseCommand
{
    protected $verb = Constant::DIVIDE;
    protected $operator = '/';
    protected $calculation;

    public function __construct(DivideCalculation $calculation)
    {
        $this->calculation = $calculation;

        parent::__construct();
    }
}
