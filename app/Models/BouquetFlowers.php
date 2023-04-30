<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BouquetFlowers extends Pivot
{
    protected $fillable = [
        'bouquet_flowers_amount'
    ];
}
