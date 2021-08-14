<?php

namespace Jakmall\Recruitment\Calculator\History\Infrastructure;

interface HistoryFileSystemInterface
{
    public function all(string $driver);
    public function create(array $data);
    // public function find();
    // public function delete();
    // public function truncate();
}
