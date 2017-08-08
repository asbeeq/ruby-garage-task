<?php

namespace Core;


class View
{
    private $pageTitle;

    public function setPageTitle($pageTitle)
    {
        if (is_string($pageTitle)) $this->pageTitle = $pageTitle;
        return $this;
    }

    public function render($template, array $data = [], $layout = 'app')
    {
        $layout .= '.php';
        $template .= '.php';
        extract($data);

        include LAYOUT_PATH . $layout;
    }

    public static function renderPartial($path, array $data = [])
    {
        $path = TEMPLATE_PATH . $path . '.php';
        ob_start();
        extract($data);
        include $path;
        return ob_get_clean();
    }
}