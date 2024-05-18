<?php

namespace Mi\Framework;

/**
 * Class Middleware (a decorator of HttpRequest)
 * This class is meant to be sub-classed to create middleware 
 */
class Middleware extends Route {
    public static $MIDDLEWARE_NAMESPACE = "Mi\\Framework\\Middlewares"; 
    private $route;

    /**
     * Setter for the middleware route
     */
    public function setRoute(Route $route) {
        $this->route = $route;
    }

    // this is decorator for HttpRequest

    public function __construct(Route $route , string $name) {
        $this->callback = array(get_class($this) , "handle");
        $this->pattern = $route->getPattern();
        $this->requestMethod = $route->getrequestMethod();
        $this->route = $route;
    }

    public function handle(array $params) {   
        // then handle the route 
        $this->route->handle($params);
    }
}