<?php

namespace App\Repositories;

use App\Models\Order;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function model(): string
    {
        return Order::class;
    }

    public function create(array $attributes): Order
    {
        $order = parent::create([
            'amount' => $attributes['amount'],
        ]);

        $order->bouquet = $attributes['bouquet_id'];
        $order->shop = $attributes['shop_id'];
        $order->save();

        return $order;
    }

    public function update(array $attributes, $id): Order
    {
        $order = parent::find($id);

        $order->fill($attributes['amount']);
        $order->bouquet = $attributes['bouquet_id'];
        $order->shop = $attributes['shop_id'];
        $order->save();

        return $order;
    }
}
