<?php

namespace App\Repositories;

use App\Models\BouquetFlowers;
use Prettus\Repository\Eloquent\BaseRepository;

class BouquetDecorsRepository extends BaseRepository
{
    public function model(): string
    {
        return BouquetFlowers::class;
    }
}
