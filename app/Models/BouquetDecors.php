<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BouquetDecors extends Pivot
{
    protected $fillable = [
        'bouquet_flowers_amount'
    ];
}
