<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group_id' => Group::inRandomOrder()->first()->id,
            'sid' => $this->faker->unique()->randomNumber,
            'pid' => $this->faker->unique()->randomNumber,
            'name' => $this->faker->sentence(5),
            'url' => $this->faker->url,
            'img' => 'http://placehold.it/140x140/'.str_replace('#', '', $this->faker->hexcolor),
            'price' => $this->faker->randomDigit,
            'currency' => $this->faker->currencyCode,
            'min_qty' => 1,
            'plural_name_format' => $this->faker->word,
        ];
    }
}
