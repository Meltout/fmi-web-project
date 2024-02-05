<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Core\App;
use Core\Console;

require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new App()
        )
    ),
    8080
);

Console::out("Started websocket server!", Console::COLOR_GREEN);
$server->run();