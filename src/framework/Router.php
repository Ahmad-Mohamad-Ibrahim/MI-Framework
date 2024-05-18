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
        $numberHandled = 0;
        foreach ($this->routes[$requestMethod] as $route) {
            $is_match = $this->patternMatch($route->getPattern(), $uri, $matches, PREG_OFFSET_CAPTURE);
            // find paramerters
            $matches = array_splice($matches, 1);

            // A partail match (we will consider it not a match)
            // so /user/1/4 won't match /user/{id}
            if(isset($matches[0]) && str_contains($matches[0][0], '/')) {
                // not a match
                continue;  
            }
            $params = array_map(function ($match, $index) use ($matches) {

                // if for example /user/1/2 and the pattern is /user/{id} 
                // get the first id ==> 1
                if(str_contains($match[0], '/')) {
                    return explode('/', $match[0])[0];  
                }
                return trim($match[0], '/');
            }, $matches, array_keys($matches));

            if ($is_match) {
                $route->handle($params);
                $numberHandled++;
            }
        }

        if($numberHandled <= 0) {
            echo Helpers::abort();
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
                // set the middleware route
                $middleware->setRoute($this->routes[$middleware->getrequestMethod()][$ind]);
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
