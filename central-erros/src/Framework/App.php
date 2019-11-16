<?php

namespace Central\Framework;

use \League\Container\Container;

class App
{
    private static $container;
    
    public static function getContainer() {
        if (static::$container === null) {
            static::$container = new \League\Container\Container;
        }
        
        return static::$container;
    }
    
    public function boot() {
       include __DIR__ . '/../../config/container.php';
    }

    public function dispatch()
    {
        $router = (include __DIR__ . '/../../config/routes.php');
        
        $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
        
        $response = $router->dispatch($request);
        (new \Zend\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);

    }
}
