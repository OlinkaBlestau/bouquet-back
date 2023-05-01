<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $users = $userRepository->paginate($request->get('limit'));

        return response(compact('users'));
    }

    public function show(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        return response(compact('user'));
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
            ])
        );

        $user = $userRepository->update($data, $id);

        return response(compact('user'));
    }
}
