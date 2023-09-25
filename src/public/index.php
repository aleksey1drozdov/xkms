<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use app\base\Config;
use app\services\DbStorage;
use app\services\HtmlPresenter;

(new Config(__DIR__ . '/../.env'));

try {
    $clickhouseData = (new DbStorage())->getDataFromClickhouse();
} catch (Throwable) {
    $clickhouseData = [];
}

try {
    $mysqlData = (new DbStorage())->getDataFromMysql();
} catch (Throwable) {
    $mysqlData = [];
}

echo (new HtmlPresenter())->render(compact('mysqlData', 'clickhouseData'));