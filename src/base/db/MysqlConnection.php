<?php
declare(strict_types=1);

namespace app\base\db;

use PDO;

/**
 * Mysql connection
 */
class MysqlConnection extends PDO
{
    private static $connection;

    /**
     * @param $dsn
     * @param $username
     * @param $passwd
     * @param $options
     */
    public function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        parent::__construct($dsn, $username, $passwd, $options);
        $this->setAttribute(self::ATTR_DEFAULT_FETCH_MODE, self::FETCH_ASSOC);
    }

    /**
     * @return self
     */
    public static function connection(): self
    {
        if (empty(self::$connection)) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;port=%s',
                getenv('DB_MYSQL_HOST'),
                getenv('DB_MYSQL_DBNAME'),
                getenv('DB_MYSQL_PORT'),
            );
            self::$connection = new self($dsn, getenv('DB_MYSQL_USER'), getenv('DB_MYSQL_PASS'));
        }
        return self::$connection;
    }
}
