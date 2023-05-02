<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\UserAuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->create(array_merge(
            $request->only([
                'first_name',
                'last_name',
                'email',
                'address',
                'phone',
            ]),
            ['password' => bcrypt($request->password)],
        ));

        return response(compact('user'));
    }

    public function login(Request $request, UserAuthService $userService): Response
    {
        $result = $userService->login($request);
        return response($result, $result['code']);
    }

    public function logout(Request $request, UserAuthService $userService): Response
    {
        return response($userService->logout($request));
    }
}
