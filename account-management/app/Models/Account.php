<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    protected $fillable = [
        'enrollment_id', 'account_id', 'institution_id', 'institution_name',
        'last_four', 'link_self', 'link_details', 'link_balances', 'link_transactions',
        'account_name', 'account_type', 'account_subtype', 'status', 'currency'
    ];
}
