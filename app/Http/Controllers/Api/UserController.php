<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $users = $userRepository->paginate($request->get('limit'));

        return response()->success(compact('users'));
    }

    public function show(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->show($id);

        return response()->success(compact('user'));
    }

    public function update(Request $request, int $id, UserRepository $userRepository): Response
    {
        $data = array_merge(
            $request->only([
                'first_name',
                'last_name',
                'email',
                'address',
                'phone',
            ]),
            [$request->only(['password' => bcrypt($request->password)])]
        );

        $user = $userRepository->update($data, $id);

        return response()->success(compact('user'));
    }
}
