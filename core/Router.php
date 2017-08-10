<?php

namespace Core;

use FastRoute;

class Router
{

    private static $dispatcher;

    private static $routs;

    /**
     * Main route function
     */
    public static function route()
    {
        self::setDispatcher();

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = self::$dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                self::errorPage('404', 'Not Found');
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                self::errorPage('405', 'Method Not Allowed');
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                list($class, $method) = explode("_", $handler, 2);
                $class = 'Controller\\' . ucfirst($class) . 'Controller';
                $method = 'action' . ucfirst($method);
                if (class_exists($class) && method_exists($class, $method)) {
                    call_user_func_array([new $class, $method], $vars);
                } else {
                    self::errorPage('500', 'Internal Server Error');
                }
                break;
        }
    }

    private static function loadRouts()
    {
        self::$routs = include(CONFIG_PATH . 'routers.php');
    }

    private static function setDispatcher()
    {
        self::loadRouts();

        self::$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            foreach (self::$routs as $rout) {
                $r->addRoute($rout[0], $rout[1], $rout[2]);
            }
        });
    }

    /**
     * Render error page
     */
    private static function errorPage($code, $message)
    {
        header('HTTP/1.1 ' . $code . ' ' . $message);
        header('Status: ' . $code . ' ' . $message);
        $view = new View();
        $view->setPageTitle($message)->render('/errors/' . $code);
    }

    public static function redirect($url, $statusCode = 303) {
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $url;
        header('Location: ' . $url, true, $statusCode);
    }

    public static function isAjax()
    {
        $requestWith = $_SERVER['HTTP_X_REQUESTED_WITH'];
        if(isset($requestWith) && !empty($requestWith) && strtolower($requestWith) == 'xmlhttprequest') {
            return true;
        }
        return false;

    }
}