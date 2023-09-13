<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
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
            "image" => "gallery/image-$imageNumber.jpg",
            "is_active" => fake()->randomElement([0, 1]),
        ];
    }
}
