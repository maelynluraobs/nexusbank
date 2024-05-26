<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payee extends Model
{
    protected $fillable = [
        'scheme', 'address', 'name', 'type', 'account_id'
    ];

    // Define any relationships here
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}