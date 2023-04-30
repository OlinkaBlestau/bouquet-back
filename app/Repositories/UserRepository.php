<?php

namespace App\Repositories;

use App\Models\Bouquet;
use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model(): string
    {
        return User::class;
    }

    public function update(array $attributes, $id): Bouquet
    {
        $bouquet = parent::find($id);

        $bouquet->user = $attributes['user_id'];
        $bouquet->total_price = $attributes['total_price'];
        $bouquet->save();

        return $bouquet;
    }
}
