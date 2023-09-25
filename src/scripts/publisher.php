<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use app\base\Config;
use app\base\Logger;
use app\services\FileParser;
use app\services\Publisher;
use Monolog\Level;

(new Config(__DIR__ . '/../.env'));

$errorLog = Logger::instance(Level::Debug, 'x');

$urls = (new FileParser())->getUrls();

$publisher = new Publisher(
    getenv('RABBIT_DEFAULT_QUEUED_NAME'),
    getenv('RABBIT_DEFAULT_EXCHANGE'),
    $errorLog
);

foreach ($urls as $url) {
    $publisher->push($url);
    dump(sprintf('%s url pushed', $url));
    $sleepSeconds = rand(1,100);
    dump(sprintf('Sleep %d seconds', $sleepSeconds));
    sleep($sleepSeconds);
}
