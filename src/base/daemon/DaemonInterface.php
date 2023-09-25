<?php
declare(strict_types=1);

namespace app\base\daemon;

use ErrorException;

/**
 * Daemon contract
 */
interface DaemonInterface
{
    /**
     * Signal handler
     *
     * @param int $signalNumber
     * @return void
     */
    public function signalHandler(int $signalNumber): void;

    /**
     * Alarm handler
     *
     * @param int $signalNumber
     * @return void
     */
    public function alarmHandler(int $signalNumber): void;

    /**
     * Restart the consumer on an existing connection
     * @throws ErrorException
     */
    public function restart();

    /**
     * Close the connection to the server
     */
    public function stopHard();

    /**
     * Close the channel to the server
     */
    public function stopSoft();

    /**
     * Tell the server you are going to stop consuming
     * It will finish up the last message and not send you any more
     */
    public function stop();

    /**
     * Work process
     */
    public function work();

    /**
     * Configuration
     */
    public function prepare();

    /**
     * Flush configuration
     */
    public function flush();

    /**
     *  Tell the server you are going to restart consuming
     */
    public function shouldRestart();

    /**
     *  Tell the server you are going to stop consuming
     */
    public function shouldStop();
}