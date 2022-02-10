<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Регистрация
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        /** @var User $user */
        $user = $this->user::create($data);

        return $this->successResponse('Пользователь зарегистрирован!', [
            'token' => $user->createToken('tokens')->plainTextToken,
            'user' => $user,
        ]);
    }

    /**
     * Авторизация
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function signin(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return make_response('Неверный логин или пароль', 422);
        }

        /** @var User $user */
        $user = auth()->user();
        return $this->successResponse('Токен получен', [
            'token' => $user->createToken('tokens')->plainTextToken,
            'user' => $user,
        ]);
    }

    /**
     * Выход
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function signout(Request $request): JsonResponse
    {
        auth()->user()->tokens()
            ->where('id', Str::before($request->bearerToken(), '|'))
            ->delete();
        
        return $this->successResponse('Токен отозван');
    }
}