<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Specify the table name if it does not follow the convention
    protected $table = 'transactions';

    // Define the primary key if it is not the default 'id'
    protected $primaryKey = 'transaction_id';
    public $incrementing = false; // Since transaction_id is a string, not an auto-incrementing integer

    // Specify the properties that can be mass-assigned
    protected $fillable = [
        'account_id',
        'amount',
        'date',
        'description',
        'details',
        'processing_status',
        'category',
        'counterparty_name',
        'counterparty_type',
        'status',
        'transaction_id',
        'link_self',
        'link_account',
        'running_balance',
        'transaction_type',
    ];

    // Cast 'details' to JSON
    protected $casts = [
        'details' => 'array',
    ];

    // Timestamps
    public $timestamps = true;
}
