<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use app\base\Config;
use app\base\Logger;
use app\services\Consumer;
use Monolog\Level;

(new Config(__DIR__ . '/../.env'));
$errorLog = Logger::instance(Level::Debug, 'x');

(new Consumer(
    getenv('RABBIT_DEFAULT_QUEUED_NAME'),
    getenv('RABBIT_DEFAULT_EXCHANGE'),
    $errorLog)
)->lifeCircle();
