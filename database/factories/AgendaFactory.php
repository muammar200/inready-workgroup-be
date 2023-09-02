<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agenda>
 */
class AgendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        return [
            "title" => fake()->sentence(3),
            "location" => fake()->sentence(2),
            "time" => fake()->date(),
            "created_by" => fake()->randomElement($userIds),
            "updated_by" => fake()->randomElement($userIds),
        ];
    }
}
