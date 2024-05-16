<?php

namespace Mi\Framework;

abstract class Route
{
    // A route might have : $pattern, callback.
    // this is  abstract class as it is a supertype for routes and middlewares
    protected $pattern;
    protected $requestMethod;
    protected $callback;

    // each HttpRoute or Middleware should implement this
    abstract public function handle(array $params);

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    public function middleware(string $name): Route
    {
        $middleware = new Middleware($this, $name); // will take this
        // TODO: some how I need to tell the router about this change
        // The router should call the handle on the last middleware assigned
        return $middleware;
    }
}
