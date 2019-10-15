<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));

        $request = Request::create(
            route('auth.login'),
            'post',
            $request->only('email', 'password')
        );

        return \Route::dispatch($request);
    }

    protected function create(array $data)
    {
        return User::create($data)->syncRoles('user');
    }
}
