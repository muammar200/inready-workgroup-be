<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Major;
use App\Models\Concentration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
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
        $majorIds = Major::all();
        $concentrationIds = Concentration::all();
        $userIds = User::all();
        return [
            "nri" => fake()->randomNumber(9, true),
            "name" => fake()->name(),
            // "photo" => "member_photo/image-$imageNumber.jpg",
            "photo" => "syahid.jpg",
            "address" => fake()->sentence(3,true),
            "pob" => fake()->sentence(2, true),
            "dob" => fake()->date(),
            "gender" => fake()->randomElement(["male", "female"]),
            "generation" => fake()->numberBetween(0, 10),
            "major_id" => fake()->randomElement($majorIds),
            "concentration_id" => fake()->randomElement($concentrationIds),
            "position" => fake()->word(),
            "phone" => fake()->phoneNumber(),
            "email" => fake()->email(),
            "instagram" => fake()->sentence(1, true),
            "facebook" => fake()->sentence(1, true),
            "created_by" => fake()->randomElement($userIds),
            "updated_by" => fake()->randomElement($userIds),
        ];
    }
}
