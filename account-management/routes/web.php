<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'accounts'], function () use ($router) {
    $router->get('/accounts', 'AccountController@listAccounts'); // List all accounts
    $router->get('/accounts/{accountId}', 'AccountController@getAccount'); // Get specific account
    $router->delete('/accounts/{accountId}', 'AccountController@deleteAccount'); // Delete specific account
    $router->delete('/accounts', 'AccountController@deleteAllAccounts'); // Delete all accounts
});
