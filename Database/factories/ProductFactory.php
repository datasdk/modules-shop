<?php

namespace Modules\Shop\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Shop\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => ['da' => $this->faker->word()],
            'description' => ['da' => $this->faker->sentence()],
            'price' => $this->faker->randomFloat(2, 1, 100),
            'status' => 'active',
        ];
    }
}
