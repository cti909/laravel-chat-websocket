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
        'owner_id',
        'target_id',
        'status'
    ];
    function owner()
    {
        return $this->belongsTo(User::class);
    }
    function target()
    {
        return $this->belongsTo(User::class);
    }
}
