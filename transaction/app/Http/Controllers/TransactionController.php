<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    // Fetch a specific transaction by account ID and transaction ID
    public function show($account_id, $transaction_id)
    {
        $response = Http::withToken(env('TELLER_API_TOKEN'))
                        ->get(env('TELLER_API_BASE_URL') . "/accounts/{$account_id}/transactions/{$transaction_id}");

        return $response->json();
    }

    // Fetch all transactions for a specific account with optional pagination
    public function index($account_id)
    {
        $count = request()->query('count', 10); // Default to 10 if count is not specified
        $from_id = request()->query('from_id');

        $response = Http::withToken(env('TELLER_API_TOKEN'))
                        ->get(env('TELLER_API_BASE_URL') . "/accounts/{$account_id}/transactions", [
                            'count' => $count,
                            'from_id' => $from_id
                        ]);

        return $response->json();
    }
}
