<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPhoneNumber extends Model
{
    // use HasFactory;
    protected $table = "users_phone_number";
    protected $fillable = [
        'added_by',
        'user_id',
        'phone_number'
    ];
}
