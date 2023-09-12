<?php

namespace App\Services\Message;

use App\Http\Requests\Message\StoreMessageRequest;
use Illuminate\Http\Request;

interface IMessageService
{
    public static function storeMessage(StoreMessageRequest $request);
}
