<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Flower extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'color',
      'price',
      'storage_flowers_amount',
      'img_path',
    ];

    public function bouquets(): BelongsToMany
    {
        return $this->belongsToMany(Bouquet::class)->using(BouquetFlowers::class);
    }
}
