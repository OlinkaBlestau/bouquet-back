<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bouquet;
use App\Models\Decor;
use App\Models\Flower;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->has(
                Bouquet::factory()
                    ->count(3)
                    ->has(Order::factory()
                        ->count(3)
                        ->for(Shop::factory()->count(3))
                    )
                    ->hasAttached(Flower::factory()->count(10))
                    ->hasAttached(Decor::factory()->count(10))
            )
            ->create();
    }
}
