<?php

namespace App\Http\Middleware;

use App\Constants\GlobalConstant;
use App\Http\Responses\BaseHTTPResponse;
use App\Http\Responses\BaseResponse;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIdMatch
{
    use BaseResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy user_id từ request
        $userId = $request->input('owner_id');
        // Lấy id từ JWT (Auth::id() trong trường hợp bạn đang sử dụng JWT Auth)
        $jwt_id = Auth::id();
        if ($userId != $jwt_id) {
            // return response()->json(['message' => 'User ID does not match JWT ID'], 403);
            $statusCode = 403;
            $message = 'User ID does not match JWT ID';
            return response()->json([
                'statusMessage' => BaseHTTPResponse::$HTTP[$statusCode],
                'statusCode' => $statusCode,
                'message' => $message,
                'time' => Carbon::now()->format(GlobalConstant::$FORMAT_DATETIME),
                'path' => $request->getRequestUri()
            ], $statusCode);
        }
        return $next($request);
    }
}
