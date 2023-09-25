<?php
declare(strict_types=1);

namespace app\services;

use app\base\daemon\DaemonAbstract;
use app\base\queue\RabbitConnection;
use Exception;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use Psr\Log\LoggerInterface;

/**
 * Consume delivered message
 */
class Consumer extends DaemonAbstract
{
    private AbstractChannel $channel;
    private string $queue;
    private string $exchange;
    private LoggerInterface $logger;

    /**
     * @throws Exception
     */
    public function __construct(string $queue, string $exchange, LoggerInterface $logger)
    {
        parent::__construct($logger);

        $this->queue = $queue;
        $this->exchange = $exchange;
        $this->logger = $logger;
    }

    /**
     * @throws Exception
     */
    private function configureChannel(string $queue, string $exchange): void
    {
        $this->channel = RabbitConnection::connection('listener')->channel();
        $this->channel->queue_declare($queue);
        $this->channel->exchange_declare($exchange, AMQPExchangeType::DIRECT);
        $this->channel->queue_bind($queue, $exchange);
    }

    /**
     * @return void
     */
    public function work(): void
    {
        $msg = $this->channel->basic_get($this->queue);

        if (null !== $msg) {
            $messageBytes = (new UrlParser())->parse($msg->body);

            (new DbStorage())->save($msg->body, $messageBytes);

            $this->channel->basic_ack($msg->getDeliveryTag(), true);

            $this->logger->debug('CONSUMER GET MESSAGE', ['msg' => $msg->body, 'bytes' => $messageBytes]);
        }
    }

    /**
     * @throws Exception
     */
    public function prepare(): void
    {
        $this->configureChannel($this->queue, $this->exchange);
    }

    /**
     * @return void
     */
    public function flush(): void
    {
    }
}
