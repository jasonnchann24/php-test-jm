<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jakmall\Recruitment\Calculator\Commands\Calculations\CalculationFactory;
use Jakmall\Recruitment\Calculator\Commands\Traits\CommandsTrait;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Utils\Constant;
use Throwable;

class CalculatorController
{
    use CommandsTrait;

    protected $factory;
    protected $history;

    public function __construct(CalculationFactory $factory, CommandHistoryManagerInterface $history)
    {
        $this->factory = $factory;
        $this->history = $history;
    }

    public function calculate($command, Request $request)
    {
        try {
            $calculation = $this->factory->create($command);
            $inputs = $request->get('input');
            $res = $calculation->calculateAll($inputs);

            $description = $this->generateCalculationDescription($inputs, $this->getOperator($command));
            $calculation->saveToLog($command, $description, $res, Constant::DRIVER_COMPOSITE, $this->history);

            return JsonResponse::create([
                'command' => $command,
                'operation' => $description,
                "result" => $res
            ]);
        } catch (Throwable $e) {
            return JsonResponse::create(['error' => $e->getMessage()], 400);
        }
    }

    private function getOperator(string $command)
    {
        switch ($command) {
            case Constant::ADD:
                return '+';
            case Constant::DIVIDE:
                return '/';
            case Constant::MULTIPLY:
                return '*';
            case Constant::POWER:
                return '^';
            case Constant::SUBTRACT:
                return '-';
        }
    }
}
