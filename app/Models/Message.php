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
        'is_deleted',
        'sender_id',
        'conversation_id',
    ];
    function sender()
    {
        return $this->belongsTo(User::class);
    }
    function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    function messageUser()
    {
        return $this->hasMany(MessageUser::class);
    }
}
