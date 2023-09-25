<?php
declare(strict_types=1);

namespace app\services;

/**
 * FileParser
 */
class FileParser
{
    private const FILE_PATH = '/src/storage/urls';

    private $fileHandler;

    public function __construct()
    {
        $this->fileHandler = fopen(self::FILE_PATH, 'rb');
    }

    /**
     * @return array
     */
    public function getUrls(): array
    {
        $result = [];
        while (false !== ($buffer = fgets($this->fileHandler, 4096))) {
            $result[] = preg_replace("[\s+]", "", $buffer);
        }

        fclose($this->fileHandler);

        return $result;
    }
}
