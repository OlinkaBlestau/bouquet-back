<?php

namespace App\Repositories;

use App\Models\Bouquet;
use Prettus\Repository\Eloquent\BaseRepository;

class BouquetRepository extends BaseRepository
{
    public function model(): string
    {
        return Bouquet::class;
    }
}
