<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required',
        ]);

        $user = $this->user::whereEmail($data['email'])->first();
        if (!$user) {
            $data['password'] = bcrypt($data['password']);

            $this->user::create($data);

            return response()->json([], 201);
        }

        return response()->json([
                'message' => 'Указанный email уже зарегистрирован',
            ], 422);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'string|required',
        ]);

        if (auth()->attempt($data)) {
            /** @var User $user */
            $user = auth()->user();
        } else {
            return response()->json([
                'message' => 'Неверный логин или пароль',
            ], 422);
        }

        $newToken = $user->createToken(null);

        return response()->json([
            'access_token' => $newToken->accessToken,
            'expires_in' => $newToken->token->expires_at->getTimestamp()-time(),
            'user' => $user,
        ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();
        $accessToken->revoke();

        return response()->json();
    }
}
