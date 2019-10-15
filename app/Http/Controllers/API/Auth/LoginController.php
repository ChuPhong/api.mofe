<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $clientID;
    private $clientSecret;

    public function __construct()
    {
        $this->clientID = 2;
        $this->clientSecret = \DB::table('oauth_clients')->find($this->clientID)->secret;
    }

    /**
     * Thực hiện đăng nhập
     * @param LoginRequest $request
     * @return mixed|\Psr\Http\Message\ResponseInterface|null
     */
    public function login(LoginRequest $request)
    {
        try {
            $response = $this->attemptLogin($request);
            return $this->sendLoginResponse($response);
        } catch (\GuzzleHttp\Exception\RequestException $exception) {
            return $exception->getResponse();
        }
    }

    // Gửi thông tin qua laravel passport để tạo jwt token
    private function attemptLogin(Request $request)
    {
        $http = new \GuzzleHttp\Client();
        return $http->post(route('auth.generate.token'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->clientID,
                'client_secret' => $this->clientSecret,
                'username' => $request->get('email'),
                'password' => $request->get('password'),
                'scope' => null
            ]
        ]);
    }

    /**
     * Trả kết quả đăng nhập về user
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    private function sendLoginResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        $response = json_decode((string)$response->getBody(), true);
        unset($response['refresh_token']);

        return $response;
    }
}
