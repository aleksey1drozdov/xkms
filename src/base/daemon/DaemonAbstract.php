<?php
declare(strict_types=1);

namespace app\base\daemon;

use Psr\Log\LoggerInterface;

/**
 * DaemonAbstract
 */
abstract class DaemonAbstract implements DaemonInterface
{
    private $restart = false;
    private $stop = false;

    private $logger;

    /**
     * DaemonAbstract constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        if (extension_loaded('pcntl')) {
            pcntl_signal(SIGTERM, [$this, 'signalHandler']);
            pcntl_signal(SIGHUP, [$this, 'signalHandler']);
            pcntl_signal(SIGINT, [$this, 'signalHandler']);
            pcntl_signal(SIGQUIT, [$this, 'signalHandler']);
            pcntl_signal(SIGUSR1, [$this, 'signalHandler']);
            pcntl_signal(SIGUSR2, [$this, 'signalHandler']);
            pcntl_signal(SIGALRM, [$this, 'alarmHandler']);
        } else {
            $this->logger->critical('UNABLE TO PROCESS SIGNALS');
            exit(1);
        }
    }

    /**
     * @return void
     */
    final protected function dispatch(): void
    {
        pcntl_signal_dispatch();
    }

    /**
     * @param int $signalNumber
     * @return void
     */
    public function signalHandler(int $signalNumber): void
    {
        $this->logger->debug('SIGNAL: #' . $signalNumber);

        switch ($signalNumber) {
            case SIGTERM:  // 15 : supervisor default stop
            case SIGQUIT:  // 3  : kill -s QUIT
                $this->stopHard();
                break;
            case SIGINT:   // 2  : ctrl+c
                $this->stop();
                break;
            case SIGHUP:   // 1  : kill -s HUP
                $this->restart();
                break;
            case SIGUSR1:  // 10 : kill -s USR
                // send an alarm in 1 second
                pcntl_alarm(1);
                break;
            case SIGUSR2:  // 12 : kill -s USR2
                // send an alarm in 10 seconds
                pcntl_alarm(10);
                break;
            default:
                break;
        }
    }

    /**
     * @param int $signalNumber
     * @return void
     */
    public function alarmHandler(int $signalNumber): void
    {
        $this->logger->alert('ALARM: #' . $signalNumber);
    }

    /**
     * @return void
     */
    public function restart(): void
    {
        $this->logger->debug('RESTART');
        $this->restart = true;
    }

    /**
     * @return void
     */
    public function stopHard(): void
    {
        $this->logger->critical('STOPPING HARD');
        $this->stop = true;
    }

    /**
     * @return void
     */
    public function stopSoft(): void
    {
        $this->logger->warning('STOPPING SOFT');
    }

    /**
     * @return void
     */
    public function stop(): void
    {
        $this->logger->info('STOPPING');
        $this->restart = true;
        $this->stop = true;
    }

    /**
     * @return bool
     */
    public function shouldRestart(): bool
    {
        return !$this->restart;
    }

    /**
     * @return bool
     */
    public function shouldStop(): bool
    {
        return !$this->stop;
    }

    /**
     * @return void
     */
    final public function lifeCircle(): void
    {
        do {
            $this->prepare();
            do {
                $this->work();
                $this->dispatch();

                if ($this->shouldRestart()) {
                    $this->flush();
                }
            } while ($this->shouldRestart());
        } while ($this->shouldStop());
    }
}
