<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use JsonException;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws JsonException
     */
    public function run(): void
    {
        $jsonPath = dirname(__DIR__,2).'/products.json';
        $products = json_decode(file_get_contents($jsonPath), true, 512, JSON_THROW_ON_ERROR);
        $products = collect($products)->map(function($product) {
             return [
                'name' => ucwords($product['name']),
                'price' => $product['price'],
                'created_at' => now(),
                'updated_at' => now()
            ];

        })->toArray();
        Product::insert($products);
    }
}
