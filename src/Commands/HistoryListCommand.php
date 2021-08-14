<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Console_Table;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Utils\Constant;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class HistoryListCommand extends BaseCommand
{
    protected $verb = 'history:list';

    public function getDescription()
    {
        return sprintf('List all calculation history');
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
            $res = $this->history->find($id);
        } else {
            $res = $this->history->findAll($driver);
        }

        $this->printClient($res);
    }

    private function printClient(array $data): void
    {
        $table = new Console_Table();
        $table->setHeaders(['ID', 'COMMAND', 'OPERATION', 'RESULT']);
        foreach ($data as $key => $val) {
            $d = json_decode($val);
            $table->addRow([$d->id, $d->command, $d->operation, $d->result]);
        }
        echo $table->getTable();
    }
}
