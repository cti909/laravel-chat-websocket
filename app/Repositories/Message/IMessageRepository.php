<?php

namespace App\Repositories\Message;

use App\Repositories\IBaseRepository;

interface IMessageRepository extends IBaseRepository
{
    public function createMessageAndStatus(mixed $data);
    public function seenMessage(mixed $data);
}
