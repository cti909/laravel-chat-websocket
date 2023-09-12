<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageUser extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'status',
        'user_id',
        'message_id'
    ];
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function message()
    {
        return $this->belongsTo(Message::class);
    }
}
