<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Exception;
use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class BaseCommand extends Command
{
    /**
     * @var string
     */
    protected $verb;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    public function __construct()
    {
        $commandVerb = $this->getCommandVerb();

        $this->signature = sprintf(
            '%s {numbers* : The numbers to be %s}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );
        $this->description = sprintf('%s all given Numbers', ucfirst($commandVerb));

        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return $this->verb;
    }

    protected function getCommandPassiveVerb(): string
    {
        $postfix = 'ed';

        switch (substr($this->verb, -1)) {
            case 'y':
                $postfix = 'ied';
                break;
            case 'e':
                $postfix = 'd';
                break;
        }

        return $this->verb . $postfix;
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculateAll($numbers);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        if (($this->operator === '^' || $this->verb === 'power') && count($numbers) > 2) {
            throw new Exception(Constant::POWER_EXCEPTION_MESSAGE);
        }

        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }
}
