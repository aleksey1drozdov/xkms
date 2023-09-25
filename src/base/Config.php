<?php
declare(strict_types=1);

namespace app\base;

use Exception;

/**
 * Parsing env five
 */
class Config
{
    private $path;

    /**
     * Config constructor.
     * @param string $configFile
     */
    public function __construct(string $configFile)
    {
        $this->path = $configFile;
        $this->prepare();
    }

    /**
     * Prepare env file
     */
    private function prepare(): void
    {
        try {
            if (!file_exists($this->path)) {
                throw new Exception('Config file not found');
            }
            $file = file_get_contents($this->path);
            $tmp = explode("\n", $file);
            if (empty($tmp)) {
                throw new Exception('Empty config file');
            }
            foreach ($tmp as $string) {
                if (empty($string)) {
                    continue;
                }
                [$var, $val] = explode("=", $string);
                $var = trim($var);
                $val = trim($val);
                if (empty($var) && empty($val)) {
                    continue;
                }
                $this->save($var, $val);
            }
        } catch (Exception $e) {
//TODO ????
        }
    }

    /**
     * @param string $var
     * @param string $val
     * @return void
     */
    private function save(string $var, string $val): void
    {
        putenv(mb_strtoupper($var) . '=' . $val);
    }

    /**
     * @param $var
     * @return array|false|string
     */
    public function get($var)
    {
        return getenv(mb_strtoupper($var));
    }
}