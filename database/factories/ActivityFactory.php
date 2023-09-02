<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck("id")->toArray();
        return [
            "title" => fake()->sentence(3),
            "location" => fake()->sentence(5),
            "description" => fake()->sentence(10),
            "registration_link" => fake()->sentence(2),
            "flayer_image" => "flayer.jpg",
            "time" => fake()->date(),
            "created_by" => fake()->randomElement($userIds),
            "updated_by" => fake()->randomElement($userIds),
        ];
    }
}
