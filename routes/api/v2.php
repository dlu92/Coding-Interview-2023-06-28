<?php

/*
|--------------------------------------------------------------------------
| Application Routes API V2
|--------------------------------------------------------------------------
*/

$router->group([
    'prefix'    => 'v2',
    'namespace' => '\App\Http\Controllers\v2'
], function() use ($router) {

    $router->get('/tests','TestController@index');

    $router->group([
        'prefix' => 'tests/{test_id}'
    ], function() use ($router) {

        $router->get('/questions','QuestionController@index');
        $router->put('/questions/{question_id}','QuestionController@update');

    });

});