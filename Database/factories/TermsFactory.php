<?php

namespace Modules\Shop\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Shop\Models\Terms;

class TermsFactory extends Factory
{
    protected $model = Terms::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(3),
            'content' => [
                'da' => $this->faker->paragraph(),
                'en' => $this->faker->paragraph(),
            ],
        ];
    }
}
