<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    private $connection;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USERNAME'),
            env('RABBITMQ_PASSWORD'),
        );
        $this->channel = $this->connection->channel();
    }

    public function sendWithDirectExchange(string $exchange, string $routingKey, string $msg): void
    {
        try {
            $this->channel->exchange_declare($exchange, 'direct', false, true, false);

            $message = new AMQPMessage($msg);

            $this->channel->basic_publish($message, $exchange, $routingKey);
        } catch (\Throwable $th) {
            \Log::info($th);
            throw new Exception('Failed to send message with direct exchange.');
        }
    }

    public function close(): void
    {
        try {
            if ($this->channel) {
                $this->channel->close();
            }

            if ($this->connection) {
                $this->connection->close();
            }
        } catch (\Throwable $th) {
            \Log::info($th);
            throw new Exception('Failed to close RabbitMQ connection and channel.');
        }
    }
}
