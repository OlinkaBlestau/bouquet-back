<?php

namespace App\Repositories;

use App\Models\Bouquet;
use App\Models\Decor;
use App\Models\Shop;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;

class ShopRepository extends BaseRepository
{
    public function model(): string
    {
        return Shop::class;
    }
}