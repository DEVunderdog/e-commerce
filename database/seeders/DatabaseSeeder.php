<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 users
        User::factory()->count(10)->create()->each(function ($user) {
            // Create 5 products per user
            $products = Product::factory()->count(5)->create();

            // Create 2-3 orders per user
            $orders = Order::factory()->count(rand(2, 3))->create([
                'user_id' => $user->id,
            ]);

            // Add order items to each order
            foreach ($orders as $order) {
                $orderItems = [];
                // Select 1-3 random products from the user's products
                $randomProducts = $products->random(rand(1, 3));
                foreach ($randomProducts as $product) {
                    $orderItems[] = [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => rand(1, 5),
                    ];
                }
                OrderItems::insert($orderItems);
            }
        });
    }
}
