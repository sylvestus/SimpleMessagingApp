<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    // use HasFactory;
    protected $table = "message_history";
    protected $fillable = [
        'added_by',
        'twilio_message_id',
        'body',
        'recipient',
        "status"
    ];
}
