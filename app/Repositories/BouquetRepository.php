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
        $bouquet->flowers()->attach($attributes['flowers'], ["bouquet_flowers_amount" => 1]);
        $bouquet->decors()->attach($attributes['decors'], ["bouquet_decors_amount" => 1]);

        $bouquet->configuration = json_encode($configuration);
        $bouquet->save();

        $bouquet = $this->model->with(['flowers', 'decors'])->find($bouquet->id);

        return $bouquet;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->with(['flowers', 'decors'])->find($id);
    }

    public function update(array $attributes, $id)
    {
        $configuration = $attributes['configuration'];
        unset($attributes['configuration']);
        $bouquet =  parent::update($attributes, $id);

        $bouquet->flowers()->detach();
        $bouquet->decors()->detach();

        $bouquet->flowers()->attach($attributes['flowers'], ["bouquet_flowers_amount" => 1]);
        $bouquet->decors()->attach($attributes['decors'], ["bouquet_decors_amount" => 1]);

        $bouquet->configuration = json_encode($configuration);
        $bouquet->save();

        $bouquet = $this->model->with(['flowers', 'decors'])->find($bouquet->id);

        return $bouquet;
    }
}
