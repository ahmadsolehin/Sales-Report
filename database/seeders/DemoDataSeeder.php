<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Customers
        $states = ['Selangor', 'Johor', 'Sabah', 'Sarawak', 'Penang'];
        $customers = collect();

        for ($i = 1; $i <= 20; $i++) {
            $customers->push(Customer::create([
                'name'  => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'state' => $faker->randomElement($states),
            ]));
        }

        // Categories
        $categoryNames = ['Electronics', 'Home & Living', 'Books', 'Toys', 'Groceries'];
        $categories = collect();

        foreach ($categoryNames as $name) {
            $categories->push(Category::create(['name' => $name]));
        }

        // Products
        $products = collect();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 10; $i++) {
                $products->push(Product::create([
                    'name'        => $category->name . ' Product ' . $i,
                    'category_id' => $category->id,
                    'price'       => $faker->numberBetween(10, 500),
                ]));
            }
        }

        // Orders + Order Items (last 60 days)
        for ($i = 1; $i <= 100; $i++) {
            $customer = $customers->random();
            $orderDate = now()->subDays(rand(0, 60));

            $order = Order::create([
                'customer_id'  => $customer->id,
                'order_date'   => $orderDate,
                'total_amount' => 0,
            ]);

            $itemsCount = rand(1, 5);
            $total = 0;

            for ($j = 1; $j <= $itemsCount; $j++) {
                $product = $products->random();
                $qty = rand(1, 5);
                $unitPrice = $product->price;
                $subtotal = $qty * $unitPrice;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal'   => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total_amount' => $total]);
        }
    }
}

