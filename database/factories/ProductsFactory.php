<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' =>  fake()->name(),
            'price' => fake()->numberBetween(100, 900),
            'color_id' => fake()->randomElement([1, 2, 3, 4, 5]),
            'size_id' => fake()->randomElement([1, 2, 3, 4, 5]),
            'category_id' => 3,
            'description' => fake()->text(),
            'img' => 'upload/default.jpg',
        ];
    }
}