<?php

namespace Jakmall\Recruitment\Calculator\History\Infrastructure;

interface HistoryFileSystemInterface
{
    public function all(string $driver);
    public function create(array $data);
    public function find(string $id, string $driver);
    public function bumpData(string $id);
    public function delete(string $id, string $driver);
    public function truncate(): bool;
}
