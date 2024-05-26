<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'contact_number', 'address', 'birthday', 'age', 'username', 'password'];
}
