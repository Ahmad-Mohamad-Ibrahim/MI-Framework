<?php

namespace Mi\Framework\Middlewares;

use Mi\Framework\Helpers;
use Mi\Framework\Middleware;

class Auth extends Middleware
{
    public function handle(array $params) {
        // middleware specific code
        // check if the user is authenticated
        $isAuth = true;
        // check Auth
        if(! $isAuth) {
            echo Helpers::abort();
            die();
        }

        // call the next middleware or the handle()
        $this->route->handle($params);

    }
}