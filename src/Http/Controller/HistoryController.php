<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Jakmall\Recruitment\Calculator\History\CommandHistoryManager;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class HistoryController
{
    protected $history;

    public function __construct(CommandHistoryManager $history)
    {
        $this->history = $history;
    }

    public function index(Request $request)
    {
        // todo: modify codes to get history
        $driver = $request->get('driver') ?? Constant::DRIVER_COMPOSITE;
        $data = $this->history->findAll($driver);
        $res = $this->toJson($data);

        return JsonResponse::create($res);
    }

    public function show($id, Request $request)
    {
        $driver = $request->get('driver') ?? Constant::DRIVER_COMPOSITE;
        $data = $this->history->find($id, $driver);
        $res = $this->toJson($data);
        return JsonResponse::create($res);
    }

    public function remove($id)
    {
        // todo: modify codes to remove history
        $this->history->clear($id);
        return JsonResponse::create([], 204);
    }

    private function toJson(array $data)
    {
        $res = [];
        foreach ($data as $key => $d) {
            array_push($res, json_decode($d));
        }

        return $res;
    }
}
