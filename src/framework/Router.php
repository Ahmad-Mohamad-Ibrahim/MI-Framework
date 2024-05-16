<?php

namespace Mi\Framework;

class Router
{
    // Stores routes
    /**
     * @var array routes an array of Route(s)
     */
    private $routes = array();

    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    public function get(string $pattern, callable|array $callback): Route
    { // [App/Controllers/UserController::class, 'index']
        // create a new HttpRoute (might use a factoy method)
        // add to $routes array
        $route = new HttpRoute(self::normalize($pattern), $callback, 'GET');
        $this->routes['GET'][] = $route;

        return $route; // important so I can chain ->middleware
    }

    public function run()
    {
        $req = Request::getInstance();
        // get the request method
        $requestMethod = $req->getRequestMethod();
        $uri = $req->getUrl();
        // loop through all the routes and handle them (some how)
        // if there is a match, call the handle method
        foreach ($this->routes[$requestMethod] as $route) {
            $is_match = $this->patternMatch($route->getPattern(), $uri, $matches, PREG_OFFSET_CAPTURE);
            // find paramerters
            $matches = array_splice($matches, 1);
            $params = array_map(function ($match, $index) use ($matches) {
                // kind does give all I need
                return trim($match[0], '/');
            }, $matches, array_keys($matches));

            if ($is_match) {
                $route->handle($params);
            }
        }
    }

    private function patternMatch($pattern, $uri, &$matches, $flags)
    {
        // pattern = /users/{id}
        $pattern = preg_replace("/\/{(.*?)}/", "/(.*?)", $pattern);
        // pattern = /users/(.*?)

        return boolval(preg_match("#^" . $pattern . "$#", $uri, $matches, $flags));
    }


    public function setMiddleware(Middleware $middleware)
    {
        // loop through the routes with the method from middleware
        foreach ($this->routes[$middleware->getrequestMethod()] as $ind => $route) {
            // look for a match for the middleware pattern
            if ($route->getPattern() === $middleware->getPattern()) {
                // replace the httpRoute/middleware with the new middleware
                $this->routes[$middleware->getrequestMethod()][$ind] = $middleware;
            }
        }
    }

    public static function normalize($pattern)
    {
        return "/" . trim($pattern, "/"); // normalized form is /home, /, /about
    }
}
