<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'accounts'], function () use ($router) {
    $router->post('/{accountId}/payees', 'PayeeController@create');
    $router->options('/{accountId}/payments', 'PaymentController@discoverSupportedSchemes');
    $router->post('/{accountId}/payments', 'PaymentController@initiatePayment');
    $router->get('/{accountId}/payments', 'PaymentController@listPayments');
    $router->get('/{accountId}/payments/{paymentId}', 'PaymentController@getPayment');
});
