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
        $memberIds = Member::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();
        return [
            "member_id" => self::$counter - 1,
            "title" => fake()->sentence(3, true),
            "description" => fake()->sentences(5, true),
            "link" => str_replace(" ", "", fake()->sentence(4, true)) . ".com",
            "image" => "work/work-$imageNumber.jpg",
            "is_active" => fake()->randomElement([0, 1]),
            "is_best" => fake()->randomElement([0,1]),
            "created_by" => fake()->randomElement($userIds),
            "updated_by" => fake()->randomElement($userIds),
        ];
    }
}
