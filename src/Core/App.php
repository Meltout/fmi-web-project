<?php

namespace Core;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Models\Table;
use Models\Client;

class App implements MessageComponentInterface
{
    protected \SplObjectStorage $tables;

    public function __construct()
    {
        $this->tables = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        Console::out("New connection: {$conn->resourceId}", Console::COLOR_GREEN);
    }

    public function onMessage(ConnectionInterface $from_conn, $msg)
    {
        Console::out("New message: {$msg}", Console::COLOR_YELLOW);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $conn->close();

        Console::out("Connection {$conn->resourceId} was disconnected", Console::COLOR_RED);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}