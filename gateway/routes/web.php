<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {
    // Account endpoints
    $router->get('/fetch', 'GatewayController@fetchAccounts');
    $router->get('/accounts', 'GatewayController@listAccounts');
    $router->get('/accounts/{accountId}', 'GatewayController@getAccount');
    $router->delete('/accounts/{accountId}', 'GatewayController@deleteAccount');
    $router->delete('/accounts', 'GatewayController@deleteAllAccounts');

    // Payment endpoints
    $router->post('/accounts/{accountId}/payees', 'GatewayController@createPayee');
    $router->post('/accounts/{accountId}/payments', 'GatewayController@createPayment');
    $router->get('/accounts/{accountId}/payments', 'GatewayController@listPayments');
    $router->get('/accounts/{accountId}/payments/{paymentId}', 'GatewayController@showPayment');

    // Transaction endpoints
    $router->get('/accounts/{accountId}/transactions/{transactionId}', 'GatewayController@showTransaction');
    $router->get('/accounts/{accountId}/transactions', 'GatewayController@listTransactions');
});
