<?php

namespace App\Repositories;

use App\Models\Decor;
use App\Validators\DecorValidator;
use Prettus\Repository\Eloquent\BaseRepository;

class DecorRepository extends BaseRepository
{
    public function model(): string
    {
        return Decor::class;
    }

    public function validator(): string
    {
        return DecorValidator::class;
    }
}
