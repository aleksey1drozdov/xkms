<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use app\base\Config;
use app\base\db\ClickhouseConnection;
use app\base\db\MysqlConnection;
use app\base\queue\RabbitConnection;

(new Config(__DIR__.'/../.env'));

/**
 * @return bool
 */
function checkMysqlDbConnection(): bool
{
    try {
        $connection = MysqlConnection::connection();
        $connection->exec('select 1');
    } catch (Throwable) {
        return false;
    }

    return true;
}

/**
 * @return bool
 */
function checkRabbitConnection(): bool
{
    try {
        return RabbitConnection::connection('healthcheck')->isConnected();
    } catch (Throwable) {
        return false;
    }
}

/**
 * @return bool
 */
function checkClickhouseConnection(): bool
{
    try {
        $connection = ClickhouseConnection::connection();
        $connection->exec('select 1');
    } catch (Throwable) {
        return false;
    }

    return true;
}

dump(sprintf('Mysql: %s', checkMysqlDbConnection() ? 'on': 'off'));
dump(sprintf('Clickhouse: %s', checkClickhouseConnection() ? 'on': 'off'));
dump(sprintf('Rabbit: %s', checkRabbitConnection() ? 'on': 'off'));

