<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = ucwords($this->faker->words(rand(2, 4), true));
        return [
            'name' => $name, 
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 50, 5000), 
            'category' => $this->faker->randomElement([
                'Electronics',
                'Fashion',
                'Home & Living',
                'Beauty',
                'Sports',
                'Toys',
                'Automotive',
            ]),
            'status' => $this->faker->randomElement(['available', 'inactive', 'out_of_stock', 'archived']),
        ];
    }
}
