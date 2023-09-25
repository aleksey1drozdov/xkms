<?php
declare(strict_types=1);

namespace app\services;

use app\base\db\ClickhouseConnection;
use app\base\db\MysqlConnection;
use PDO;

/**
 * DbStorage
 */
class DbStorage
{
    /**
     * @param string $url
     * @param int $bytes
     * @return bool|int
     */
    public function save(string $url, int $bytes): bool|int
    {
        $connection = MysqlConnection::connection();

        $timestamp = time();

        $sql = sprintf(
            "INSERT INTO `urls` (`created_at`, `created_month`, `created_day`, `created_hour`, `created_minute`, `url`, `content_length`) VALUES ('%s', %d, %d, %d, %d, '%s', %d);",
            date(DATE_RFC3339, $timestamp),
            date('m', $timestamp),
            date('d', $timestamp),
            date('H', $timestamp),
            date('i', $timestamp),
            $url,
            $bytes
        );

        return $connection->exec($sql);
    }

    /**
     * @return array
     */
    public function getDataFromMysql(): array
    {
        return $this->getData(MysqlConnection::connection());
    }

    /**
     * @return array
     */
    public function getDataFromClickhouse(): array
    {
        return $this->getData(ClickhouseConnection::connection());
    }

    /**
     * @param PDO $connection
     * @return array
     */
    public function getData(PDO $connection): array
    {
        $sql = 'select 
                    max(id) as id, 
                    max(created_at) as max_created_at, 
                    min(created_at) as min_created_at, 
                    count(1) as count, 
                    avg(content_length) as avg, 
                    created_month, created_day, created_hour, created_minute from urls 
                    group by created_month, created_day, created_hour, created_minute
                    order by id;';

        return $connection->query($sql)->fetchAll();
    }
}
