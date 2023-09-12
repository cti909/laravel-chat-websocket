<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'notification',
        'user_id',
        'read_at'
    ];
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
