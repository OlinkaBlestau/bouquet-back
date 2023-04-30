<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bouquet extends Model
{
    use HasFactory;

    protected $fillable = [
      'total_price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function flowers(): BelongsToMany
    {
        return $this->belongsToMany(Flower::class)->using(BouquetFlowers::class);
    }

    public function decors(): BelongsToMany
    {
        return $this->belongsToMany(Decor::class)->using(BouquetDecors::class);
    }
}
