<?php
// app/Http/Controllers/PayeeController.php

namespace App\Http\Controllers;

use App\Models\Payee;
use Illuminate\Http\Request;

class PayeeController extends Controller
{
    public function create(Request $request, $account_id)
    {
        $this->validate($request, [
            'scheme' => 'required|string',
            'address' => 'required|string',
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $payee = Payee::create([
            'scheme' => $request->scheme,
            'address' => $request->address,
            'name' => $request->name,
            'type' => $request->type,
            'account_id' => $account_id,
        ]);

        // Simulate MFA requirement
        if ($this->requiresMFA()) {
            return response()->json(['connect_token' => 'xxxxxxxxxxxxxx'], 202);
        }

        return response()->json($payee, 201);
    }

    private function requiresMFA()
    {
        // Simulate an MFA check
        return false; // Change to true to simulate MFA required
    }
}
