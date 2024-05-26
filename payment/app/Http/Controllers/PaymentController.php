<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Payee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class PaymentController extends BaseController
{
    // Existing code...

    public function initiatePayment(Request $request, $accountId)
    {
        $this->validate($request, [
            'amount' => 'required|string',
            'memo' => 'required|string',
            'payee' => 'required|array',
            'payee.scheme' => 'required|string',
            'payee.address' => 'required|string',
            'payee.name' => 'string',
            'payee.type' => 'string',
        ]);

        try {
            $response = $this->client->post("/accounts/{$accountId}/payments", [
                'json' => $request->all(),
            ]);
            $payment = json_decode($response->getBody()->getContents(), true);
            return response()->json($payment, 201);
        } catch (\Exception $e) {
            Log::error('Error initiating payment: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to initiate payment'], 500);
        }
    }

    public function listPayments($accountId)
    {
        try {
            $response = $this->client->get("/accounts/{$accountId}/payments");
            $payments = json_decode($response->getBody()->getContents(), true);
            return response()->json($payments);
        } catch (\Exception $e) {
            Log::error('Error listing payments: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to list payments'], 500);
        }
    }

    public function getPayment($accountId, $paymentId)
    {
        try {
            $response = $this->client->get("/accounts/{$accountId}/payments/{$paymentId}");
            $payment = json_decode($response->getBody()->getContents(), true);
            return response()->json($payment);
        } catch (\Exception $e) {
            Log::error('Error retrieving payment: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to retrieve payment'], 500);
        }
    }

}
