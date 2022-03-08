<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement([Cart::ADDED, Cart::REMOVED, Cart::CHECKED_OUT]),
            'count' => function (array $attributes) {
                if($attributes['status'] === Cart::REMOVED) {
                    return 0;
                }
                if(in_array($attributes['status'], [Cart::ADDED, Cart::CHECKED_OUT], true)) {
                    return  $this->faker->numberBetween(1, 10);
                }
                return 0;
            }
        ];
    }
}
