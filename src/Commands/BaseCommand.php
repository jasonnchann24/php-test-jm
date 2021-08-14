<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Exception;
use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Commands\Traits\CommandsTrait;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class BaseCommand extends Command
{
    use CommandsTrait;

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

    protected $history;
    protected $calculation;


    public function __construct()
    {
        $this->signature = $this->getSignature();
        $this->description = $this->getDescription();

        parent::__construct();
    }

    public function getDescription()
    {
        $commandVerb = $this->verb;
        return sprintf('%s all given Numbers', ucfirst($commandVerb));
    }

    public function getSignature()
    {
        return sprintf(
            '%s {numbers* : The numbers to be %s} {--driver=composite : Available drivers [file|latest|composite]}',
            $this->verb,
            $this->getCommandPassiveVerb()
        );
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

    public function handle(CommandHistoryManagerInterface $historyManager): void
    {
        $this->history = $historyManager;

        $numbers = $this->getInput();
        $description = $this->generateCalculationDescription($numbers, $this->operator);
        $result = $this->calculation->calculateAll($numbers);
        $driver = $this->option('driver') ?? 'composite';

        $this->calculation->saveToLog($this->verb, $description, $result, $driver, $historyManager);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getInput($argName = 'numbers')
    {
        return $this->argument($argName) ?? [];
    }
}
