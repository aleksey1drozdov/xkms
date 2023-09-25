<?php
declare(strict_types=1);

namespace app\base\queue;

use Exception;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPConnectionConfig;
use PhpAmqpLib\Connection\AMQPConnectionFactory;

/**
 * Rabbit connection
 */
class RabbitConnection
{
    private const VHOST = '/';

    private static array $instance = [];

    private AbstractConnection $connection;

    /**
     * @throws Exception
     */
    public function __construct(string $connectionName)
    {
        $config = new AMQPConnectionConfig();
        $config->setHost(getenv('RABBIT_HOST'));
        $config->setPort((int)getenv('RABBIT_PORT'));
        $config->setUser(getenv('RABBIT_USER'));
        $config->setPassword(getenv('RABBIT_PASS'));
        $config->setVhost(self::VHOST);
        $config->setConnectionName($connectionName);

        $this->connection = AMQPConnectionFactory::create($config);
    }

    /**
     * @param string $connectionName
     * @return AbstractConnection
     * @throws Exception
     */
    public static function connection(string $connectionName): AbstractConnection
    {
        if (!isset(self::$instance[$connectionName])) {
            self::$instance[$connectionName] = (new self($connectionName))->connection;
        }
        if (!self::$instance[$connectionName]->isConnected()) {
            self::$instance[$connectionName]->reconnect();
        }

        return self::$instance[$connectionName];
    }
}
