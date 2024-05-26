<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount', 'memo', 'payee_id', 'account_id', 'reference', 'date'
    ];

    // Define the relationship with Payee
    public function payee()
    {
        return $this->belongsTo(Payee::class);
    }
}
