<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use FastRoute\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function(){
    return 'Hello World';
});

$router->group(['prefix'=>'api','json.response'], function() use ($router) {

    /**
     * Api version 1
     */
    $router->group([], function() use ($router) {
        include __DIR__.'/api/v1.php';
    });


    /**
     * Api version 2
     */
    $router->group([], function() use ($router) {
        include __DIR__.'/api/v2.php';
    });

    $router->post('/corregirTest','PreguntasController@corregirTest'); 
});
