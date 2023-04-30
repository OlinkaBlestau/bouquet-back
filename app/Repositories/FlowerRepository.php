<?php

namespace App\Repositories;

use App\Models\Flower;
use Prettus\Repository\Eloquent\BaseRepository;

class FlowerRepository extends BaseRepository
{
    public function model(): string
    {
        return Flower::class;
    }
}
