<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BouquetDecors extends Pivot
{
    protected $fillable = [
        'decor_id',
        'bouquet_id',
        'bouquet_decors_amount'
    ];
}
