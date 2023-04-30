<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Decor>
 */
class DecorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstNameFemale(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomNumber(3),
            'storage_decors_amount' => $this->faker->randomNumber(2),
            'img_path' => $this->faker->imageUrl(),
        ];
    }
}
