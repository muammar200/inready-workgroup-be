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
            "member_id" => "1",
        ]);
        User::create([
            "username" => "albar",
            "password" => Hash::make("password"),
            "level" => "admin",
            "member_id" => "2",
        ]);
        User::create([
            "username" => "darma",
            "password" => Hash::make("password"),
            "level" => "admin",
            "member_id" => "3",
        ]);
        User::create([
            "username" => "aidil",
            "password" => Hash::make("password"),
            "level" => "admin",
            "member_id" => "4",
        ]);
    }
}
