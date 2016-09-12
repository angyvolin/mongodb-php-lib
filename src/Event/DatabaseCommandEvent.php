<?php

namespace Tequilla\MongoDB\Event;

use MongoDB\Driver\Server;
use Tequilla\MongoDB\CommandCursor;
use Tequilla\MongoDB\Exception\LogicException;

/**
 * Class DatabaseCommandEvent
 * @package Tequilla\MongoDB\Event
 */
class DatabaseCommandEvent extends Event
{
    /**
     * @var string
     */
    private $databaseName;

    /**
     * @var array
     */
    private $command;

    /**
     * @var Server
     */
    private $server;

    /**
     * @var array
     */
    private $commandCursor;

    /**
     * DatabaseCommandEvent constructor.
     * @param string $databaseName
     * @param array $command
     * @param Server $server
     */
    public function __construct($databaseName, array $command, Server $server)
    {
        $this->databaseName = $databaseName;
        $this->command = $command;
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * @return array
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return array
     */
    public function getCursor()
    {
        if (null === $this->commandCursor) {
            throw new LogicException(
                sprintf(
                    'Call on %s is denied before command result was set using %s::setCursor().',
                    __METHOD__,
                    __CLASS__
                )
            );
        }

        return $this->commandCursor;
    }

    /**
     * @param CommandCursor $cursor
     */
    public function setCursor(CommandCursor $cursor)
    {
        $this->commandCursor = $cursor;
    }

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param Server $server
     */
    public function setServer(Server $server)
    {
        $this->server = $server;
    }
}