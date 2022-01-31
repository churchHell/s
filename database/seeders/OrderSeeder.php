<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Pivots\OrderUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->count(100)->create()->each(
            fn($order) => User::inRandomOrder()->take(rand(1, User::count()))->get()->each(
                fn($user) => OrderUser::factory()->create([
                    'order_id' => $order->id, 
                    'user_id' => $user->id
                ])
            )
        );
    }
}
