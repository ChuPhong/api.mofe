<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:management.users.all')->only('index');
        $this->middleware('permission:management.users.store')->only('store');
        $this->middleware('permission:management.users.update')->only('update');
        $this->middleware('permission:management.users.destroy')->only('destroy');
    }

    /**
     * Trả về danh sách thành viên
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ?? 10;

        if ($request->has('q')) {
            $value = $request->get('q');
            $users = User::findByNameOrEmail($value)->paginate($limit);
        } else {
            $users = User::paginate($limit);
        }

        return UserResource::collection($users);
    }

    /**
     * Tạo thành viên.
     *
     * @param UserStoreRequest $request
     * @return UserResource
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->all())->assignRole($request->get('role'));
        $user->refresh();

        return new UserResource($user);
    }

    /**
     * Hiển thị thành viên.
     *
     * @param \App\User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Cập nhật dữ liệu cho thành viên.
     *
     * @param UserUpdateRequest $request
     * @param \App\User $user
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->all());

        $user->when($request->get('role'), function ($query, string $role) use ($user) {
            $user->syncRoles($role);
        });

        return new UserResource($user);
    }

    /**
     * Xóa thành viên.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => 'Bạn không thể tự xóa thông tin của chính mình'
            ])->setStatusCode(Response::HTTP_CONFLICT);
        }

        try {
            $user->delete();

            return response()->json([
                'message' => 'Xóa thành công thành viên: ' . $user->name
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi xóa thành viên'
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
