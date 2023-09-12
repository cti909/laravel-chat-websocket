<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone_number',
        'avatar',
        'address',
        'is_lock',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // message
    function messages()
    {
        return $this->hasMany(Message::class);
    }
    // conversation users
    function conversationUsers()
    {
        return $this->hasMany(ConversationUser::class);
    }
    // message users
    function messageUsers()
    {
        return $this->hasMany(MessageUser::class);
    }
    // friendship
    function owners()
    {
        return $this->hasMany(Friendship::class);
    }
    function targets()
    {
        return $this->hasMany(Friendship::class);
    }
    // notification
    function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    // use jwt
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
