<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'address',
        'telegram',
        'instagram',
        'facebook',
    ];

    public function orders(): HasMany
    {
        return  $this->hasMany(Order::class);
    }

}
