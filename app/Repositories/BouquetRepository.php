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

    public function create(array $attributes): Bouquet
    {
        $bouquet = parent::create([
            'total_price' => $attributes['total_price'],
        ]);
        $bouquet->user = $attributes['user_id'];
        $bouquet->save();

        return $bouquet;
    }

    public function update(array $attributes, $id): Bouquet
    {
        $bouquet = parent::find($id);

        $bouquet->user = $attributes['user_id'];
        $bouquet->total_price = $attributes['total_price'];
        $bouquet->save();

        return $bouquet;
    }
}
