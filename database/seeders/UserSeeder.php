<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "username" => "ikrar",
            "password" => Hash::make("password"),
            "level" => "admin",
        ]);
        User::create([
            "username" => "albar",
            "password" => Hash::make("password"),
            "level" => "admin",
        ]);
        User::create([
            "username" => "darma",
            "password" => Hash::make("password"),
            "level" => "admin",
        ]);
    }
}
