<?php

namespace Database\Seeders;

use Artisan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        $this->call(ProductSeeder::class);
        Artisan::call('cache:clear');
    }
}
