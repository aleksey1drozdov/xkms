<?php
declare(strict_types=1);

namespace app\base;

use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Level;
use Monolog\Processor\HostnameProcessor;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Logger as MonologLogger;

/**
 * Logger
 */
class Logger extends MonologLogger
{
    private const DEFAULT_CHANNEL = 'x';
    private static $instance;

    /**
     * @param $level
     * @param $name
     */
    public function __construct($level = Level::Error, $name = null)
    {
        $this->name = $name ?? self::DEFAULT_CHANNEL;
        parent::__construct(
            $this->name,
            [
                new RotatingFileHandler($this->getFilePath(), 30, $level),
                new FirePHPHandler()
            ],
            [
                new IntrospectionProcessor(),
                new MemoryPeakUsageProcessor(),
                new ProcessIdProcessor(),
                new UidProcessor(),
                new HostnameProcessor(),
            ]
        );
    }

    /**
     * @return string
     */
    private function getFilePath(): string
    {
        return __DIR__ . getenv('LOG_PATH').'/' . $this->name.'.log';
    }

    /**
     * @param null $level
     * @param null $name
     * @return self
     */
    public static function instance($level = null, $name = null): self
    {
        if (!isset(self::$instance[$name])) {
            self::$instance[$name] = new self($level, $name);
        }
        return self::$instance[$name];
    }
}