<?php

namespace App\Repositories;

use App\Models\Bouquet;
use App\Validators\BouquetValidator;
use Prettus\Repository\Eloquent\BaseRepository;

class BouquetRepository extends BaseRepository
{
    public function model(): string
    {
        return Bouquet::class;
    }

    public function validator(): string
    {
        return BouquetValidator::class;
    }
}
