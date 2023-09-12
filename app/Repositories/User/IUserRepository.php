<?php

namespace App\Repositories\User;

use App\Repositories\IBaseRepository;

interface IUserRepository extends IBaseRepository
{
    function updateUser(mixed $data, mixed $id);
    function resetUserPassword(mixed $data, mixed $id);
    function actionFriendInvitation(mixed $data);
}
