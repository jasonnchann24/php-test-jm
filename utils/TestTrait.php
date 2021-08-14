<?php

namespace Jakmall\Recruitment\Calculator\Utils;

use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use ReflectionClass;
use Symfony\Component\Console\Tester\CommandTester;

trait TestTrait
{
    protected $command;
    protected $commandTester;
    protected $classToTest;

    public function makeConsole()
    {
        $container = new Container();
        $dispatcher = new Dispatcher();
        $app = new Application($container, $dispatcher, '0.1');
        $appConfig = require __DIR__ . '/../config/app.php';
        $providers = $appConfig['providers'];
        foreach ($providers as $provider) {
            $container->make($provider)->register($container);
        }
        $testedCommand = $app->getLaravel()->make($this->classToTest);
        $app->addCommands([$testedCommand]);

        $this->command = $app->find($this->getCommandName());
        $this->commandTester = new CommandTester($this->command);
    }

    private function getCommandName(): string
    {
        $reflect = new ReflectionClass($this->classToTest);
        $className = $reflect->getShortName();
        return strtolower(explode("Command", $className)[0]);
    }
}
