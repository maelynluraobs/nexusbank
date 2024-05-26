<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('/accounts', [TransactionController::class, 'listAccounts']);
Route::get('/accounts/{accountId}', [TransactionController::class, 'getAccount']);
Route::delete('/accounts/{accountId}', [TransactionController::class, 'deleteAccount']);
Route::delete('/accounts', [TransactionController::class, 'deleteAllAccounts']);
