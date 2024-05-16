<?php

namespace Mi\Framework;

class App
{
    public $router;
    public function __construct()
    {
        $this->router = Router::getInstance();
    }
    public function run()
    {
        // run the router
        $this->router->run();
    }
}
