<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'sender_id',
        'receiver_id',
        'status'
    ];
    function sender()
    {
        return $this->belongsTo(User::class);
    }
    function receiver()
    {
        return $this->belongsTo(User::class);
    }
}
