<?php

namespace Jakmall\Recruitment\Calculator\Commands\Traits;

trait CommandsTrait
{
    protected function generateCalculationDescription(array $numbers, $operator): string
    {
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }
}
