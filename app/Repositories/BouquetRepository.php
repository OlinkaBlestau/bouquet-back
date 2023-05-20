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

    public function create(array $attributes)
    {
        $configuration = $attributes['configuration'];
        unset($attributes['configuration']);

        $bouquet = parent::create($attributes);

        $bouquet->configuration = json_encode($configuration);
        $bouquet->save();

        return $bouquet;
    }
}
