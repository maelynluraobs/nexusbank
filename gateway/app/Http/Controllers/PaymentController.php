<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Payee;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function options($account_id)
    {
        // Currently only Zelle is supported
        return response()->json(['schemes' => [['scheme' => 'zelle']]]);
    }

    public function create(Request $request, $account_id)
    {
        $this->validate($request, [
            'amount' => 'required|string',
            'memo' => 'required|string',
            'payee' => 'required|array',
            'payee.scheme' => 'required|string',
            'payee.address' => 'required|string',
            'payee.name' => 'sometimes|required|string',
            'payee.type' => 'sometimes|required|string',
        ]);

        $payeeData = $request->payee;
        $payee = Payee::firstOrCreate(
            ['scheme' => $payeeData['scheme'], 'address' => $payeeData['address']],
            ['name' => $payeeData['name'] ?? null, 'type' => $payeeData['type'] ?? null, 'account_id' => $account_id]
        );

        $payment = Payment::create([
            'amount' => $request->amount,
            'memo' => $request->memo,
            'payee_id' => $payee->id,
            'account_id' => $account_id,
            'reference' => strtoupper(bin2hex(random_bytes(16))),
            'date' => now()->toDateString(),
        ]);

        // Simulate MFA requirement
        if ($this->requiresMFA()) {
            return response()->json(['connect_token' => 'xxxxxxxxxxxxxx'], 202);
        }

        return response()->json($payment, 201);
    }

    public function list($account_id)
    {
        $payments = Payment::where('account_id', $account_id)->with('payee')->get();
        return response()->json($payments);
    }

    public function show($account_id, $payment_id)
    {
        $payment = Payment::where('account_id', $account_id)->where('id', $payment_id)->with('payee')->firstOrFail();
        return response()->json($payment);
    }

    private function requiresMFA()
    {
        // Simulate an MFA check
        return false; // Change to true to simulate MFA required
    }
}
