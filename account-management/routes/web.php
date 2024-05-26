<?php 

$router->group(['prefix' => 'accounts'], function () use ($router) {
    $router->get('/', 'AccountController@index');
    $router->post('/', 'AccountController@store');
    $router->get('/{id}', 'AccountController@show');

});