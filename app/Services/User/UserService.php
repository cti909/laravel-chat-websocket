<?php

namespace App\Services\User;

use App\Http\Filters\BaseFilter;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\BaseHTTPResponse;
use App\Repositories\User\IUserRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\User;

class UserService extends BaseService implements IUserService
{
    private static $userRepository;
    private static $filter;
    /**
     * Construct
     */
    public function __construct(IUserRepository $userRepository)
    {
        self::$userRepository = $userRepository;
        self::$filter = new BaseFilter;
    }
    public static function getUserList(Request $request)
    {
        // url: http://127.0.0.1:8000/api/users?where=name[like]t&page=1&limit=10
        // Xử  lý định dạng cột
        $column = self::$filter->transformColumn($request, "users.");
        // Xử lý điều kiện trong where
        $where = self::$filter->transformWhere($request, "users.");
        // Xử lý quan hệ trong relations
        $relations = self::$filter->transformRelations($request);
        // Xử lý các trường không có giá trị
        // dd($column);
        $page = $request->page ?? 1;
        $sortType = $request->sortType ?? 'asc';
        $limit = $request->limit ?? 10;

        return self::$userRepository->findAll([
            'where' => $where, // điều kiện
            'relations' => $relations, // bảng truy vấn
            'column' => $column, // cột để sort
            'orderBy' => $sortType,
            'limit' => $limit,  // giới hạn record/page
            'page' => $page // page cần lấy
        ]);
    }

    public static function getUserById($id)
    {
        return self::$userRepository->findById($id);
    }

    public static function createUser(StoreUserRequest $request)
    {
        return self::$userRepository->createUser($request->input());
    }

    public static function updateUser(UpdateUserRequest $request, $id)
    {
        $image_name = null;
        if ($request->hasFile('image')) {
            $image_name = self::renameImage($request->file('image'), "notes");
            self::resizeImage($folder = "notes", $image_name);
            $request->merge(['avatar' => $image_name]);
        }
        return self::$userRepository->update($request->input(), $id);
    }

    public static function deleteUser(mixed $id)
    {
        return self::$userRepository->destroy($id);
    }

    public static function resetPassword(ResetPasswordRequest $request, mixed $id)
    {
        return self::$userRepository->resetUserPassword($request->input(), $id);
    }

    public static function lockUser(Request $request, mixed $id)
    {
        return self::$userRepository->update($request->input(), $id);
    }

    public static function actionFriendInvitation(Request $request)
    {
        $request_data = [
            "owner_id" => $request->input("owner_id"),
            "target_id" => $request->input("target_id"),
            "status" => $request->input("status"),
        ];
        return self::$userRepository->actionFriendInvitation($request_data);
    }
}
