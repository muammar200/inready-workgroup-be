<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    static $counter = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageNumber = self::$counter;
        self::$counter++;
        $userIds = User::pluck("id")->toArray();
        return [
            "title" => fake()->sentence(3),
            "location" => fake()->sentence(5),
            "description" => fake()->sentence(10),
            "registration_link" => fake()->sentence(2),
            "flayer_image" => "flayer_image/image-$imageNumber.jpg",
            "time" => fake()->date(),
            "created_by" => fake()->randomElement($userIds),
            "updated_by" => fake()->randomElement($userIds),
        ];
    }
}
