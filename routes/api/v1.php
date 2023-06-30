<?php

/*
|--------------------------------------------------------------------------
| Application Routes API V1
|--------------------------------------------------------------------------
*/

$router->group([
    'prefix'    =>'v1',
    'namespace' => '\App\Http\Controllers\v1'
], function() use ($router) {

    $router->get('/tests','TestController@index');
    
});