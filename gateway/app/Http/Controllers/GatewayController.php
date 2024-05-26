<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GatewayController extends Controller
{
    protected $accountServiceUrl;
    protected $paymentServiceUrl;
    protected $transactionServiceUrl;

    public function __construct()
    {
        $this->accountServiceUrl = env('ACCOUNT_SERVICE_URL');
        $this->paymentServiceUrl = env('PAYMENT_SERVICE_URL');
        $this->transactionServiceUrl = env('TRANSACTION_SERVICE_URL');
    }

    // Account related endpoints
    public function fetchAccounts()
    {
        $response = Http::get("{$this->accountServiceUrl}/api/fetch");
        return response()->json($response->json());
    }

    public function listAccounts()

    
    {

        $baseUri = config('services.account_service.base_uri');
        $response = Http::get("{$baseUri}/accounts");

        
        $response = Http::get("{$this->accountServiceUrl}/api/accounts");
        return response()->json($response->json());
    }

    public function getAccount($accountId)
    {
        $response = Http::get("{$this->accountServiceUrl}/api/accounts/{$accountId}");
        return response()->json($response->json());
    }

    public function deleteAccount($accountId)
    {
        $response = Http::delete("{$this->accountServiceUrl}/api/accounts/{$accountId}");
        return response()->json($response->json(), $response->status());
    }

    public function deleteAllAccounts()
    {
        $response = Http::delete("{$this->accountServiceUrl}/api/accounts");
        return response()->json($response->json(), $response->status());
    }

    // Payment related endpoints
    public function createPayee(Request $request, $accountId)
    {
        $response = Http::post("{$this->paymentServiceUrl}/accounts/{$accountId}/payees", $request->all());
        return response()->json($response->json(), $response->status());
    }

    public function createPayment(Request $request, $accountId)
    {
        $response = Http::post("{$this->paymentServiceUrl}/accounts/{$accountId}/payments", $request->all());
        return response()->json($response->json(), $response->status());
    }

    public function listPayments($accountId)
    {
        $response = Http::get("{$this->paymentServiceUrl}/accounts/{$accountId}/payments");
        return response()->json($response->json());
    }

    public function showPayment($accountId, $paymentId)
    {
        $response = Http::get("{$this->paymentServiceUrl}/accounts/{$accountId}/payments/{$paymentId}");
        return response()->json($response->json());
    }

    // Transaction related endpoints
    public function showTransaction($accountId, $transactionId)
    {
        $response = Http::get("{$this->transactionServiceUrl}/accounts/{$accountId}/transactions/{$transactionId}");
        return response()->json($response->json());
    }

    public function listTransactions($accountId)
    {
        $response = Http::get("{$this->transactionServiceUrl}/accounts/{$accountId}/transactions");
        return response()->json($response->json());
    }
}
