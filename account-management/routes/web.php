<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'accounts'], function () use ($router) {
    $router->get('/', 'AccountController@listAccounts'); // List all accounts
    $router->get('/{accountId}', 'AccountController@getAccount'); // Get specific account
    $router->delete('/{accountId}', 'AccountController@deleteAccount'); // Delete specific account
    $router->delete('/', 'AccountController@deleteAllAccounts'); // Delete all accounts
});
