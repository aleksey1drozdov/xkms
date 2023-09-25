<?php
declare(strict_types=1);

namespace app\base\db;

use PDO;

/**
 * Clickhouse connection
 */
class ClickhouseConnection extends PDO
{
    private static $connection;

    /**
     * @return self
     */
    public static function connection(): self
    {
        if(empty(self::$connection)) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;port=%s',
                getenv('DB_CLICKHOUSE_HOST'),
                getenv('DB_CLICKHOUSE_DBNAME'),
                getenv('DB_CLICKHOUSE_PORT')
            );
            self::$connection = new self($dsn, getenv('DB_CLICKHOUSE_USER'));
        }
        return self::$connection;
    }

}