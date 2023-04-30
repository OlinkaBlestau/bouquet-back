<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserAuthService
{
    public function register(Request $request): User
    {
        $user = User::create(array_merge(
            $request->only([
                'first_name',
                'last_name',
                'email',
                'address',
                'phone',
            ]),
            ['password' => bcrypt($request->password)],
        ));

        return $user;
    }

    public function login(Request $request): array
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return [
                'message' => 'You cannot sign with those credentials',
                'errors' => 'Unauthorised',
                'code' => 401,
            ];
        }

        $token = Auth::user()->createToken(config('app.name'));

        $token->token->expires_at = Carbon::now()->addDay();
        $token->token->save();

        $user = Auth::user();

        return [
            'userId' => Auth::id(),
            'role' => $user->role,
            'token' => $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
            'code' => 200,
        ];
    }

    public function logout(Request $request): array
    {
        $request->user()->token()->revoke();

        return [
            'message' => 'You are successfully logged out',
        ];
    }
}
