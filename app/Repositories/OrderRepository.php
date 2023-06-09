<?php

namespace App\Repositories;

use App\Models\Order;
use App\Validators\OrderValidator;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function model(): string
    {
        return Order::class;
    }

    public function validator(): string
    {
        return OrderValidator::class;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->with([
            'shop',
            'bouquet.user',
            'bouquet.flowers',
            'bouquet.decors',
        ])->find($id);
    }

    public function showByUser($id)
    {
        return $this->model->whereHas('bouquet', function ($query) use ($id) {
            return $query->where('user_id', $id);
        })
            ->with([
                'shop',
                'bouquet.user',
                'bouquet.flowers',
                'bouquet.decors',
            ])
            ->get();
    }
}
