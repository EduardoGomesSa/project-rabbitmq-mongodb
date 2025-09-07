<?php

namespace App\Console\Commands;

use App\Models\LogEvent;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from RabbitMQ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest')
        );

        $channel = $connection->channel();
        $channel->queue_declare('stock-events', false, true, false, false);

        $this->info(' [*] Waiting for messages in stocke-events. To exit press CTRL+C');

        $callback = function ($msg) {
            $this->info(" [x] Mensagem recebida: " . $msg->body . "\n");

            try{
                $data = json_decode($msg->body, true);

                LogEvent::create([
                    'event' => $data['event'] ?? 'unknown',
                    'payload' => $data,
                ]);

                $this->info("[x] saved to MongoDB\n");
            } catch (\Exception $e) {
                $this->info("[!] Error saving to MongoDB: \n");
            }
        };

        $channel->basic_consume('stock-events', '', false, true, false, false, $callback);

        while ($channel->callbacks) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
