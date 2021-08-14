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
        $env =  getenv('APP_ENV');
        $this->drivers = $env == 'testing'
            ? $appConfig['test_drivers']
            : $appConfig['available_drivers'];
        $this->selectedDriver = Constant::DRIVER_COMPOSITE;
    }

    public function all(string $driver): array
    {
        $this->selectDriver($driver);
        if ($this->selectedDriver == Constant::DRIVER_COMPOSITE) {
            return $this->unMarshal(Constant::DRIVER_FILE);
        }

        if ($this->selectedDriver == Constant::DRIVER_LATEST) {
            return array_reverse($this->unMarshal($this->selectedDriver));
        }

        return $this->unMarshal($this->selectedDriver);
    }

    public function create(array $data)
    {
        $newContent = $this->marshal($data);
        $this->putToFile($newContent);
        $this->putToLatest($newContent);
    }

    public function find(string $id, string $driver)
    {
        $this->selectDriver($driver);
        $res = [];
        if ($this->selectedDriver == Constant::DRIVER_COMPOSITE) {
            $res = $this->getById($id, Constant::DRIVER_LATEST);
            if (count($res) > 0) {
                return $res;
            }
            $res = $this->getById($id, Constant::DRIVER_FILE);
            return $res;
        }

        $res = $this->getById($id, $this->selectedDriver);
        return $res;
    }

    public function delete(string $id, string $driver)
    {
        $this->selectDriver($driver);
        $res = [];
        $bool = false;
        if ($this->selectedDriver == Constant::DRIVER_COMPOSITE) {

            $latest = $this->deleteById($id, Constant::DRIVER_LATEST);
            $file = $this->deleteById($id, Constant::DRIVER_FILE);

            $bool = $latest || $file;
            return $bool;
        }

        $bool = $this->deleteById($id, $this->selectedDriver);
        return $bool;
    }

    public function truncate(): bool
    {
        $this->clear(Constant::DRIVER_FILE);
        $this->clear(Constant::DRIVER_LATEST);

        return true;
    }

    public function selectDriver(string $driverName = 'composite')
    {
        if (!$this->drivers[$driverName]) {
            throw new Exception("Driver not supported");
        }

        $this->selectedDriver = $driverName;
    }

    public function bumpData(string $id)
    {
        $data = $this->unMarshal(Constant::DRIVER_LATEST);
        foreach ($data as $key => $x) {
            $d = json_decode($x);
            if ($d->id == $id) {
                $pushData = $data[$key];
                array_splice($data, $key, 1);
                array_push($data, $pushData);
                $joined = join("\n", $data);
                $this->clear(Constant::DRIVER_LATEST);
                file_put_contents($this->drivers['latest']['path'], $joined . "\n", FILE_APPEND);
            }
        }
    }

    private function deleteById($id, $driver)
    {
        $data = $this->unMarshal($driver);
        foreach ($data as $key => $x) {
            $d = json_decode($x);
            if ($d->id == $id) {
                array_splice($data, $key, 1);
                $joined = join("\n", $data);
                $this->clear($driver);
                file_put_contents($this->drivers[$driver]['path'], $joined . "\n", FILE_APPEND);
                return true;
            }
        }

        return false;
    }

    private function clear($driver)
    {
        file_put_contents($this->drivers[$driver]['path'], "");
    }

    private function getById($id, $driver)
    {
        $data = $this->unMarshal($driver);
        foreach ($data as $key => $x) {
            $d = json_decode($x);
            if ($d->id == $id) {
                if ($driver == Constant::DRIVER_LATEST) {
                    $this->bumpData($id);
                }
                return (array)$data[$key];
            }
        }

        return [];
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

    private function unMarshal(string $driver): array
    {
        $res = [];
        $path = $this->drivers[$driver]['path'];
        $content = @file_get_contents($path);
        if ($content) {
            $array = explode("\n", $content);

            // remove trailing break
            array_pop($array);
            $res = $array;
        }

        return $res;
    }

    private function getLatestId()
    {
        $data = $this->unMarshal(Constant::DRIVER_FILE);
        $latestId = 0;
        if (count($data) > 0) {
            $latestData = $data[count($data) - 1];
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
                $this->clear(Constant::DRIVER_LATEST);
                file_put_contents($latestPath, $joined . "\n", FILE_APPEND);
                return;
            }
        }

        file_put_contents($latestPath, $newContent . "\n", FILE_APPEND);
    }
}
