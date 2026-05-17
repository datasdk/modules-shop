<?php

namespace Modules\Shop\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Shop\Models\Orders;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'payment_method' => 'paypal',
            'payment_status' => 'paid',
            'status' => 'completed',
            'total' => $this->faker->randomFloat(2, 10, 500),
            'currency' => 'DKK',
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
