<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationUser extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'is_owner',
        'member_id',
        'conversation_id',
    ];
    function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    function member()
    {
        return $this->belongsTo(User::class);
    }
}
