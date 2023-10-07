<?php

namespace App\Repositories\User;

use App\Constants\RoleConstant;
use App\Models\Friendship;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function getModel()
    {
        return User::class;
    }
    function createUser(mixed $data)
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
    function updateUser(mixed $data, mixed $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $data["name"],
            'password' => bcrypt($data["password"]),
            'phone_number' => $data["phone_number"],
            'address' => $data["address"],
            'avatar' => $data["image"],
        ]);
        return $user;
    }
    function resetUserPassword(mixed $data, mixed $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => bcrypt($data["password"]),
        ]);
        return $user;
    }
    function actionFriendInvitation(mixed $data)
    {
        $fsCheck = Friendship::where('owner_id', '=', $data['owner_id'])
            ->where('target_id', '=', $data['target_id'])
            ->first();
        if ($fsCheck)
            throw  new \Exception('Friend invitation is exist');
        else {
            $instance = Friendship::create($data);
            return $instance;
        }
    }
}
