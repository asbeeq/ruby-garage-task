<?php

namespace core;

abstract class Router
{
    const DEFAULT_CONTROLLER = 'main';
    const DEFAULT_ACTION = 'index';

    /**
     * Main route function
     */
    public static function route()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        $controllerName = $routes[1] ? $routes[1] : self::DEFAULT_CONTROLLER;
        $actionName = $routes[2] ? $routes[2] : self::DEFAULT_ACTION;

        $controllerName = ucfirst($controllerName) . 'Controller';
        $actionName = 'action' . ucfirst($actionName);

        $class = 'controller\\' . $controllerName;

        if (!class_exists($class)) {
            self::pageNotFound();
            return;
        }

        $controller = new $class;

        if (!method_exists($controller, $actionName)) {
            self::pageNotFound();
            return;
        }

        $controller->$actionName();

    }

    /**
     * Render page 404
     */
    private static function pageNotFound() {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        $view = new View();
        $view->setPageTitle('Page not found')->render('/errors/404');
    }
}