<?php
declare(strict_types=1);

namespace app\services;

/**
 * UrlParser
 */
class UrlParser
{
    /**
     * @param string $url
     * @return int
     */
    public function parse(string $url): int
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
        ]);
        curl_exec($ch);

        return (int)curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
    }
}