<?php

// require autoload

$base_dir = __DIR__ . "/../";

require $base_dir . "vendor/autoload.php";

// create new app
use Mi\Framework\App;
$app = new App();

$app->router->get('/' , function(Mi\Framework\Request $request) 
{ 
    echo "home";
    print_r($request->getRequestMethod());
});

// TODO: need to implement this somehow
$app->router->get('/user/{id}' , function(Mi\Framework\Request $request, $id) 
{ 
    print_r ($id);
});

// run the app
$app->run();


