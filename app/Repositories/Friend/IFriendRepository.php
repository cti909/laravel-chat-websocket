<?php

namespace App\Repositories\Friend;

use App\Repositories\IBaseRepository;

interface IFriendRepository extends IBaseRepository
{
    public function getAllFriend(mixed $data);
    public function getAllFriendInvitation(mixed $data);
    public function getFriendInvationById(mixed $data);
    public function replyInvitation(mixed $data);
    public function deleteFriendInvitation(mixed $data);
    public function sendFriendInvation(mixed $data);
}
