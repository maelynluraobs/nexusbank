<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Fetch a specific transaction by account ID and transaction ID
    public function show($account_id, $transaction_id)
    {
        // Ensure the transaction belongs to the specified account
        $transaction = Transaction::where('account_id', $account_id)
                                    ->where('transaction_id', $transaction_id)
                                    ->firstOrFail();

        return response()->json($transaction);
    }

    // Fetch all transactions for a specific account with optional pagination
    public function index($account_id)
    {
        // Fetch query parameters for pagination if they exist
        $count = request()->query('count', 10); // Default to 10 if count is not specified
        $from_id = request()->query('from_id');

        // Query transactions for the specified account
        $query = Transaction::where('account_id', $account_id);

        // If from_id is specified, fetch transactions after the specified transaction ID
        if ($from_id) {
            $query->where('transaction_id', '>', $from_id);
        }

        // Paginate the results
        $transactions = $query->paginate($count);

        return response()->json($transactions);
    }
}

