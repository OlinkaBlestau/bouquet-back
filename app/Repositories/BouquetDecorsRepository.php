<?php

namespace App\Repositories;

use App\Models\BouquetDecors;
use App\Validators\BouquetDecorsValidator;
use \Illuminate\Database\Eloquent\Builder;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class BouquetDecorsRepository extends BaseRepository
{
    private BouquetRepository $bouquetRepository;

    public function __construct(
        Application $app,
        BouquetRepository $bouquetRepository,
    )
    {
        parent::__construct($app);
        $this->bouquetRepository = $bouquetRepository;
    }


    public function model(): string
    {
        return BouquetDecors::class;
    }

    public function validator(): string
    {
        return BouquetDecorsValidator::class;
    }

    public function find($id, $columns = ['*']): Builder|Model
    {
        return $this->bouquetRepository->model
            ->with('decors')
            ->first();
    }
}
