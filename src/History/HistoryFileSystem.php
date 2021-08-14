<?php

namespace Jakmall\Recruitment\Calculator\History;

use Exception;
use Jakmall\Recruitment\Calculator\History\Infrastructure\HistoryFileSystemInterface;
use Jakmall\Recruitment\Calculator\Utils\Constant;

class HistoryFileSystem implements HistoryFileSystemInterface
{
    protected $drivers;
    protected $selectedDriver;

    public function __construct()
    {
        $appConfig = require __DIR__ . '/../../config/app.php';
        $this->drivers = $appConfig['available_drivers'];
        $this->selectedDriver = Constant::DRIVER_COMPOSITE;
    }

    public function all()
    {
        //
    }

    public function create(array $data)
    {
        $newContent = $this->marshal($data);
        $this->putToFile($newContent);
        $this->putToLatest($newContent);
    }

    public function find()
    {
        //
    }

    public function delete()
    {
        //
    }
    public function truncate()
    {
        //
    }

    public function selectDriver(string $driverName)
    {
        if (!$this->drivers[$driverName]) {
            throw new Exception("Driver not supported");
        }

        $this->selectedDriver = $driverName;
    }

    private function marshal(array $data): string
    {
        $id = $this->getLatestId();
        $encode = [
            'id' => $id,
            'command' => ucfirst($data['verb']),
            'operation' => $data['description'],
            'result' => $data['result']
        ];

        return json_encode($encode);
    }

    private function getLatestId()
    {
        $file = @file_get_contents($this->drivers['file']['path']);
        $latestId = 0;
        if ($file) {
            $latestData = explode("\n", $file);

            $latestData = $latestData[count($latestData) - 2];
            $latestId = (json_decode($latestData))->id;
        }

        return $latestId + 1;
    }

    private function putToFile(string $newContent)
    {
        $filePath = $this->drivers['file']['path'];
        file_put_contents($filePath, $newContent . "\n", FILE_APPEND);
    }

    private function putToLatest(string $newContent)
    {
        $latestPath = $this->drivers['latest']['path'];
        $latestContent = @file_get_contents($latestPath);
        if ($latestContent) {
            $latestData = explode("\n", $latestContent);
            if (count($latestData) >= 11) {
                array_pop($latestData);
                array_shift($latestData);
                array_push($latestData, $newContent);
                $joined = join("\n", $latestData);
                file_put_contents($latestPath, "");
                file_put_contents($latestPath, $joined . "\n", FILE_APPEND);
                return;
            }
        }

        file_put_contents($latestPath, $newContent . "\n", FILE_APPEND);
    }
}
