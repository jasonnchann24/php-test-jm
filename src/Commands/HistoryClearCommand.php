<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Utils\Constant;
use Throwable;

class HistoryClearCommand extends BaseCommand
{
    protected $verb = 'history:clear';

    public function getDescription()
    {
        return sprintf('Clear calculation history, if id not specified, it will clear all history.');
    }

    public function getSignature()
    {
        return sprintf(
            '%s {id? : The ID of a data} {--driver=composite : Available drivers [file|latest|composite]}',
            $this->getCommandVerb(),
        );
    }

    public function handle(CommandHistoryManagerInterface $historyManager): void
    {
        $this->history = $historyManager;

        $id = $this->getInput('id');
        $driver = $this->option('driver') ?? Constant::DRIVER_COMPOSITE;

        if ($id) {
            $res = $this->history->clear($id, $driver);
        } else {
            $res = $this->history->clearAll($driver);
        }

        $comment = 'Deleted';
        if (!$res) {
            $comment = 'Not found';
        }

        $this->comment(sprintf("%s", $comment));
    }
}
