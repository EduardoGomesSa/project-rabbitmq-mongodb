<?php
require __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('stock-events', false, true, false, false);

echo " [*] Aguardando mensagens. CTRL+C para sair\n";

$callback = function($msg) {
    echo " [x] Recebido: ", $msg->body, "\n";
};

$channel->basic_consume('stock-events', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}
