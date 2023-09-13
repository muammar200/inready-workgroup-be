<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = fake()->sentence(3);
        return [
            "title" => $title,
            "slug" => Str::slug($title),
            "location" => fake()->sentence(2),
            "time" => fake()->dateTimeBetween("-1 years", Carbon::now()->addDays(90)),
            "description" => fake()->sentence(10),
            "created_by" => fake()->randomElement($userIds),
            "updated_by" => fake()->randomElement($userIds),
        ];
    }
}
