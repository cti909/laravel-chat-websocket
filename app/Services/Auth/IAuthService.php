<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;

interface IAuthService
{
    public static function me();
    public static function login(LoginRequest $request);
    public static function refresh(Request $request);
    public static function register(RegisterRequest $request);
}
