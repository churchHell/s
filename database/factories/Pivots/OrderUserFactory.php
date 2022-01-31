<?php

namespace Database\Factories\Pivots;

use App\Models\Order;
use App\Models\Pivots\OrderUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        OrderUser::flushEventListeners();
        return [
            'order_id' => Order::first()->id,
            'user_id' => User::first()->id,
            'delivery' => $this->faker->randomDigit,
            'qty' => $this->faker->randomDigit
        ];
    }
}
