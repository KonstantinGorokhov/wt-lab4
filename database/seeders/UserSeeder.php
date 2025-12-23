<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            "name" => "Admin",
            "username" => "admin",
            "email" => "admin@test.com",
            "password" => Hash::make("password"),
            "is_admin" => true,
        ]);

        // 5 users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                "name" => "User {$i}",
                "username" => "user{$i}",
                "email" => "user{$i}@test.com",
                "password" => Hash::make("password"),
                "is_admin" => false,
            ]);
        }
    }
}
