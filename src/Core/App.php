<?php

namespace Core;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Models\TableModel;
use Models\ClientModel;

class App implements MessageComponentInterface
{
    protected \SplObjectStorage $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        Console::out("New connection: {$conn->resourceId}", Console::COLOR_GREEN);
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from_conn, $msg)
    {
        Console::out("New message: {$msg}", Console::COLOR_YELLOW);
        $data = json_decode(html_entity_decode(stripslashes($msg)));
        $table = new TableModel($data->table_id);

        if($data->event_type == 'modify') {
            //TODO: check if user has permission for modifying table
            if($table->get_formula($data->row, $data->col) != $data->new_formula) {
                $table->set_formula($data->row, $data->col, $data->new_formula);
                $data->new_value = $table->get_value($data->row, $data->col);
                $clients_msg = json_encode($data);
                foreach($this->clients as $conn) {
                    $conn->send($clients_msg);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {   
        $this->clients->detach($conn);
        $conn->close();

        Console::out("Connection {$conn->resourceId} was disconnected", Console::COLOR_RED);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}