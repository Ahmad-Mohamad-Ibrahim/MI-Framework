<?php

// set the base directory
$base_dir = __DIR__ . "/../";

// require autoload
require $base_dir . "vendor/autoload.php";

$_ENV['BASE_DIR'] = $base_dir;

// loading env
$dotenv = Dotenv\Dotenv::createImmutable($base_dir);
$dotenv->load();

use Mi\Framework\App;
use Mi\Framework\Helpers;

// create new app
$app = new App();

$app->router->get('/' , function(Mi\Framework\Request $request) 
{ 
    // return Helpers::view('home.twig.php', ['name' => 'Ahmed']); 
    return Helpers::view('home', ['name' => 'Ahmed']); // note only home
});

// matches http://localhost:8888/user/1/ahmed
// $app->router->get('/user/{id}/{name}' , function(Mi\Framework\Request $request, $id, $name) 
// { 
//     return "user {$name} with {$id}";
// })->middleware('Auth');

// // matches http://localhost:8888/user/1 not the above
// $app->router->get('/user/{id}' , function(Mi\Framework\Request $request, $id) 
// { 
//     return $id;
// })->middleware('Auth');


// $app->router->get('/user/{userId}/comment/{commentId}' , function(Mi\Framework\Request $request, $userId, $commentId) 
// { 
//     return "This is a comment number {$commentId} from user number {$userId}";
// })->middleware('Auth');

// run the app
$app->run();


