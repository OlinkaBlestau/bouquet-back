<?php

namespace App\Repositories;

use App\Models\Flower;
use App\Validators\FlowerValidator;
use Prettus\Repository\Eloquent\BaseRepository;

class FlowerRepository extends BaseRepository
{
    public function model(): string
    {
        return Flower::class;
    }

    public function validator(): string
    {
        return FlowerValidator::class;
    }
}
