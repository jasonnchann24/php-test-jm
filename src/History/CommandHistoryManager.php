<?php

namespace Jakmall\Recruitment\Calculator\History;

use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Throwable;

class CommandHistoryManager implements CommandHistoryManagerInterface
{
    protected $fs;

    public function __construct()
    {
        $this->fs = new HistoryFileSystem();
    }
    /**
     * Returns array of command history.
     *
     * @return array returns an array of commands in storage
     */
    public function findAll($driver): array
    {
        return $this->fs->all($driver);
    }

    /**
     * Find a command by id.
     *
     * @param string|int $id
     * @param string $driver
     *
     * @return null|mixed returns null when id not found.
     */
    public function find($id, $driver)
    {
        return $this->fs->find($id, $driver);
    }

    /**
     * Log command data to storage.
     *
     * @param mixed $command The command to log.
     *
     * @return bool Returns true when command is logged successfully, false otherwise.
     */
    public function log($command): bool
    {
        try {
            $this->fs->create($command);
        } catch (Throwable $e) {
            error_log($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Clear a command by id
     *
     * @param string|int $id
     *
     * @return bool Returns true when data with $id is cleared successfully, false otherwise.
     */
    public function clear($id, $driver): bool
    {
        try {
            $res = $this->fs->delete($id, $driver);
        } catch (Throwable $e) {
            error_log($e->getMessage());
            return false;
        }

        return $res;
    }

    /**
     * Clear all data from storage.
     *
     * @return bool Returns true if all data is cleared successfully, false otherwise.
     */
    public function clearAll(): bool
    {
        return $this->fs->truncate();
    }
}
