<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Decor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'price',
        'storage_decors_amount',
        'img_path',
    ];

    public function bouquets(): BelongsToMany
    {
        return $this->belongsToMany(Bouquet::class)->using(BouquetDecors::class);
    }
}
