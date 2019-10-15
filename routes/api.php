<?php

Route::prefix('v1')->group(function () {
    // Route của passport, do chỉ sử dụng mỗi route oauth/token nên chỉ để 1 route
    Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->name('auth.generate.token');

    Route::prefix('auth')->group(function () {
        Route::post('login', 'API\Auth\LoginController@login')->name('auth.login');
        Route::post('register', 'API\Auth\RegisterController@register')->name('auth.register');
        Route::get('me', 'API\Auth\AuthController@me')->name('auth.me');
    });

    Route::middleware('auth:api')->group(function () {
        Route::apiResource('users', 'API\UserController');
        Route::post('users/avatar', 'API\UploadController@avatar')->name('users.avatar.store');


        Route::post('songs/thumbnail', 'API\UploadController@thumbnail')->name('songs.thumbnail.store');
        Route::post('songs/upload', 'API\UploadController@song')->name('songs.upload.store');

        Route::apiResource('artists', 'API\ArtistController')->only('index');
    });

    Route::apiResource('songs', 'API\SongController');

});

\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//    Log::info($query->sql, $query->bindings);
});

