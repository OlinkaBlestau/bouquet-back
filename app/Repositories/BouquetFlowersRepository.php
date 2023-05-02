<?php

namespace App\Repositories;

use App\Models\BouquetFlowers;
use App\Validators\BouquetFlowersValidator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;

class BouquetFlowersRepository extends BaseRepository
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
        return BouquetFlowers::class;
    }

    public function validator(): string
    {
        return BouquetFlowersValidator::class;
    }

    public function find($id, $columns = ['*']): Builder|Model
    {
        return $this->bouquetRepository->model
            ->with('flowers')
            ->first();
    }
}
