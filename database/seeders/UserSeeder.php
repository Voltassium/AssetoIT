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
            'nim' => 'V0000000',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::create([
            'name' => 'Dimas Premono',
            'nim' => 'V3423030',
            'email' => 'dimas@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Aswara Ayu',
            'nim' => 'V3423024',
            'email' => 'aswara@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Akhmad Rofiq',
            'nim' => 'V3423010',
            'email' => 'rofiq@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Andy kasa',
            'nim' => 'V3423015',
            'email' => 'andy@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Ade Kurniawan',
            'nim' => 'V3423003',
            'email' => 'ade@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Arindha Rizka',
            'nim' => 'V3423019',
            'email' => 'rizka@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Arsyad Irfan',
            'nim' => 'V3423020',
            'email' => 'irza@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
