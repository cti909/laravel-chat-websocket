<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'name',
        'member_count',
        'type',
    ];
    function messages()
    {
        return $this->hasMany(Message::class);
    }
    function conversationUser()
    {
        return $this->hasMany(ConversationUser::class);
    }
}
