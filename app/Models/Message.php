<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'content',
        'path',
        'status',
        'is_deleted',
        'conversation_id',
        'sender_id'
    ];
    function owner()
    {
        return $this->belongsTo(User::class);
    }
    function target()
    {
        return $this->belongsTo(User::class);
    }
    function messageUser()
    {
        return $this->hasMany(MessageUser::class);
    }
}
