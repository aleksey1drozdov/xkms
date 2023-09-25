<?php
declare(strict_types=1);

namespace app\services;

use app\base\queue\RabbitConnection;
use Exception;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

/**
 * Publisher
 */
class Publisher
{
    private string $exchange;
    private $channel;
    private LoggerInterface $logger;
    /**
     * @throws Exception
     */
    public function __construct(string $queue, string $exchange, LoggerInterface $logger)
    {
        $this->channel = RabbitConnection::connection('publisher')->channel();
        $this->channel->exchange_declare($exchange, AMQPExchangeType::DIRECT);
        $this->channel->queue_declare($queue);
        $this->channel->queue_bind($queue, $exchange);

        $this->exchange = getenv('RABBIT_DEFAULT_EXCHANGE');
        $this->logger = $logger;
    }

    /**
     * @param string $message
     * @return void
     */
    public function push(string $message): void
    {
        $this->channel->basic_publish(new AMQPMessage($message), $this->exchange);
        $this->logger->debug('Message add', ['msg' => $message]);
    }
}
