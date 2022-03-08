<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if (!app()->isProduction()) {
            $adminUser = User::factory()->create(['role' => User::ADMIN]);
            $user = User::factory()->create();
            $firstProduct = Product::factory()->count(5)->create()->first();

            Cart::factory()
                ->count(5)
                ->for($user)
                ->for($firstProduct)
                ->create(['status' => Cart::ADDED]);

            // Products added to cart and then removed
            Cart::factory()
                ->count(3)
                ->for($user)
                ->for($firstProduct)
                ->create(['status' => Cart::REMOVED]);

            // Create cart and the corresponding child checkout
            Cart::factory()
                ->count(4)
                ->for($user)
                ->for($firstProduct)
                ->create(['status' => Cart::CHECKED_OUT])
                ->each(function ($cart) {
                    Checkout::factory()
                        ->for($cart)
                        ->create();
                });
        }
    }
}
