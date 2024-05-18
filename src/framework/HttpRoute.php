<?php

namespace Mi\Framework;

/**
 * @class Class HttpRoute is the routes that will be stored in router and could be decorated with middlewares
 * 
 */
class HttpRoute extends Route
{
    protected $params = array();


    public function __construct(string $pattern, callable|array $callback, string $requestMethod)
    {
        $this->pattern = Router::normalize($pattern);
        $this->callback = $callback;
        $this->requestMethod = $requestMethod;
    }
    public function handle(array $params)
    {
        // handle the a request coming to this Route
        // call the callback with the params
        // check type of $callback
        if(is_callable($this->callback)) {
            // Echo what ever returned by the function
            echo call_user_func_array($this->callback, array(Request::getInstance(), ...$params));
        } else if(gettype($this->callback) == 'array') {
            // [App\Controllers\UserController::class, 'index']
            // call_user_func_array($this->callback[0], array_merge($this->callback[1], $params));
            // check if class exists
            if(class_exists($this->callback[0])) {
                // only in php you can do that
                $obj = new $this->callback[0];
                echo $obj->$this->callback[1](Request::getInstance(), ...$params);
            }
        }

    }
}
