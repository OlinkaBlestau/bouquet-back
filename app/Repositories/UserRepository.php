<?php

namespace App\Repositories;

use App\Models\User;
use App\Validators\UserValidator;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model(): string
    {
        return User::class;
    }

    public function validator(): string
    {
        return UserValidator::class;
    }
}
