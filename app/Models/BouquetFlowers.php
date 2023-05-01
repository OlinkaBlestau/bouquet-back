<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BouquetFlowers extends Pivot
{
    protected $fillable = [
        'flower_id',
        'bouquet_id',
        'bouquet_flowers_amount'
    ];
}
