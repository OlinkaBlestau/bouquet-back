<?php

namespace App\Repositories;

use App\Models\Decor;
use Prettus\Repository\Eloquent\BaseRepository;

class DecorRepository extends BaseRepository
{
    public function model(): string
    {
        return Decor::class;
    }
}
