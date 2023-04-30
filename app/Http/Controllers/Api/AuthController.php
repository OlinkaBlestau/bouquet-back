<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserAuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request, UserAuthService $userService): Response
    {
        return response($userService->register($request));
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
