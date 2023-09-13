<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
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
        return [
            "title" => fake()->sentence(3),
            "description" => fake()->sentence(15),
            "image" => "slider/image-$imageNumber.jpg",
            "is_active" => fake()->randomElement([1, 0]),
        ];
    }
}
