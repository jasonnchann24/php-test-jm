<?php

use Jakmall\Recruitment\Calculator\Commands\AddCommand;
use Jakmall\Recruitment\Calculator\Commands\DivideCommand;
use Jakmall\Recruitment\Calculator\Commands\HistoryClearCommand;
use Jakmall\Recruitment\Calculator\Commands\HistoryListCommand;
use Jakmall\Recruitment\Calculator\Commands\MultiplyCommand;
use Jakmall\Recruitment\Calculator\Commands\PowerCommand;
use Jakmall\Recruitment\Calculator\Commands\SubtractCommand;

return [
    AddCommand::class,
    SubtractCommand::class,
    MultiplyCommand::class,
    DivideCommand::class,
    PowerCommand::class,
    HistoryListCommand::class,
    HistoryClearCommand::class
];
