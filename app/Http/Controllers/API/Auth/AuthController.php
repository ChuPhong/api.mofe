<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Trả về dữ liệu của người dùng đã đăng nhập.
     */
    public function me(): UserResource
    {
        return new UserResource(auth()->user());
    }
}
