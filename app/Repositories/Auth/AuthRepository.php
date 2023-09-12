<?php

namespace App\Repositories\Auth;

use App\Constants\RoleConstant;
use App\Models\User;
use App\Repositories\BaseRepository;

class AuthRepository extends BaseRepository implements IAuthRepository
{
    public function getModel()
    {
        return User::class;
    }

    function me()
    {
        $user = auth()->user();
        return $user;
    }

    function register(mixed $data)
    {
        $pathAvatar = 'media/userAvatar/defautUser.png';
        $user = User::create([
            'name' => $data["name"],
            'email' => $data["email"],
            'avatar' => asset($pathAvatar),
            'password' => bcrypt($data["password"]),
            'phone_number' => $data["phone_number"],
            'address' => $data["address"]
        ]);
        return $user;
    }
}
