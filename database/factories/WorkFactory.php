<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $memberIds = Member::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();
        return [
            "member_id" => fake()->randomElement($memberIds),
            "title" => fake()->sentence(3, true),
            "description" => fake()->sentences(5, true),
            "link" => fake()->sentence(4, true),
            "image" => "work.jpg",
            "created_by" => fake()->randomElement($userIds),
            "updated_by" => fake()->randomElement($userIds),
        ];
    }
}
