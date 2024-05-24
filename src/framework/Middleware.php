<?php

namespace Mi\Framework;

/**
 * Class Middleware (a decorator of HttpRequest)
 * This class is meant to be sub-classed to create middleware 
 */
abstract class Middleware extends Route
{
    public static $MIDDLEWARE_NAMESPACE = "Mi\\Framework\\Middlewares";
    protected Route $route;

    /**
     * Setter for the middleware route
     *
     * @param Route $route The route object to be set for the middleware
     */
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    // this is decorator for HttpRequest

    public function __construct(Route $route, string $name)
    {
        $this->callback = array(get_class($this), "handle");
        $this->pattern = $route->getPattern();
        $this->requestMethod = $route->getrequestMethod();
        $this->route = $route;
    }

    abstract public function handle(array $params);
}
