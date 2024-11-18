<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::create([
            'name' => 'Dimas Premono',
            'email' => 'dimas@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Aswara Ayu',
            'email' => 'aswara@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Akhmad Rofiq',
            'email' => 'rofiq@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create additional regular users
        User::factory()
            ->count(5)
            ->state(function (array $attributes) {
                return ['role' => 'user'];
            })
            ->create();
    }
}
