<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\BaseHTTPResponse;
use App\Repositories\Auth\IAuthRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AuthService extends BaseService implements IAuthService
{
    private static $authRepository;
    private static $filter;
    /**
     * Construct
     */
    public function __construct(IAuthRepository $authRepository)
    {
        self::$authRepository = $authRepository;
    }
    public static function me()
    {
        return self::$authRepository->me();
    }
    public static function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        $isLogin = Auth::attempt($credentials) ? true : false;

        // dd($isLogin);
        // nếu đăng nhập thành công thì
        // tạo RA 1 TOKEN để gửi về client thông qua jwt
        // khi người dùng đưa lên mà không đúng thì 400 -> BadRequest
        $user = null;
        $refreshToken = "";
        $accessToken = "";
        if ($isLogin) {
            $user = Auth::user();
            $user = Auth::user();
            $refreshToken = JWTAuth::fromUser($user); // Tạo refresh token
            $accessToken = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addMinutes(60)->timestamp]);
        }
        $data = [
            "isLogin" => $isLogin,
            "user" => $user,
            'accessToken' => $accessToken,
            'refreshToken' => $refreshToken,
        ];
        return $data;
    }
    public static function refresh(Request $request)
    {
        $refreshToken = request('refreshToken');
        $newToken = JWTAuth::refresh($refreshToken);
        // dd($newToken);
        return $newToken;
    }
    public static function register(RegisterRequest $request)
    {
        // $image_name = null;
        // if ($request->hasFile('avatar')) {
        //     $image_name = self::renameImage($request->file('avatar'), "posts");
        //     self::resizeImage($folder = "posts", $image_name);
        // }
        // $request->merge(['avatar' => $image_name]);
        return self::$authRepository->register($request->input());
    }
}
