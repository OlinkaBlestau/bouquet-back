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
}
