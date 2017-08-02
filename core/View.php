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

    public function render($template, array $data = [], $layout = null)
    {
        if (is_null($layout)) $layout = 'app';
        $layout .= '.php';
        $template .= '.php';
        extract($data);

        include LAYOUT_PATH . $layout;
    }
}