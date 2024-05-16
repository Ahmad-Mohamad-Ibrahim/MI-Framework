<?php

namespace Mi\Framework;

/**
 * Class Middleware (a decorator of HttpRequest)
 * 
 */
class Middleware extends Route {
    public static $MIDDLEWARE_PATH = "Ahmedmi\\Ecommerse\\Middelwares"; 
    public $route;

    // this is decorator for HttpRequest

    public function __construct(Route $route , string $name) {
        $this->callback = array(self::$MIDDLEWARE_PATH . "\\{$name}::class" , "handle");
        $this->pattern = $route->getPattern();
        $this->requestMethod = $route->getrequestMethod();
        $this->route = $route;
    }

    public function handle(array $params) {
        // handle the a request coming to a Route with this middleware
        
        // then handle the route 
        $this->route->handle($params);
    }

    public function middleware(string $name): Route
    {
        $middleware = new Middleware($this, $name); // will take this
        // TODO: some how I need to tell the router about this change
        // The router should call the handle on the last middleware assigned
        // notify the Router
        Router::getInstance()->setMiddleware($this);
        return $middleware;
    }
}