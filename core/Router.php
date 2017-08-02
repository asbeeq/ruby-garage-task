<?php

namespace Core;

use FastRoute;

class Router
{

    /**
     * Main route function
     */
    public static function route()
    {
        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', 'Controller\\MainController/actionIndex');
            $r->addRoute('POST', '/method', 'Controller\\MainController/actionIndex');
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                self::pageNotFound();
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                self::methodNotAllowed();
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                list($class, $method) = explode("/", $handler, 2);
                call_user_func_array(array(new $class, $method), $vars);
                break;
        }
    }

    /**
     * Render page 404
     */
    private static function pageNotFound()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        $view = new View();
        $view->setPageTitle('Page not found')->render('/errors/404');
    }

    private static function methodNotAllowed()
    {
        header('HTTP/1.1 405 Method Not Allowed');
        header("Status: 405 Method Not Allowed");
        $view = new View();
        $view->setPageTitle('Method Not Allowed')->render('/errors/405');
    }
}