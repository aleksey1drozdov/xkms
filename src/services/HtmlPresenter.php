<?php
declare(strict_types=1);

namespace app\services;

/**
 * HtmlPresenter
 */
class HtmlPresenter
{
    private const TEMPLATE = '/src/src/templates/index.php';

    /**
     * @param array $data
     * @return string
     */
    public function render(array $data = []): string
    {
        foreach ($data as $var => $value) {
            $$var = $value;
        }

        ob_start();
        require self::TEMPLATE;
        return ob_get_clean();
    }
}
