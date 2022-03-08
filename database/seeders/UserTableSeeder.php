<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'role' => User::ADMIN,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('(Password!2)')
        ]);

        User::create([
            'first_name' => 'user',
            'last_name' => 'user',
            'role' => User::USER,
            'email' => 'user@gmail.com',
            'password' => Hash::make('(Password!2)')
        ]);
    }
}
