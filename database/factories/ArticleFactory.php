<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
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

        $categoryIds = Category::pluck('id')->toArray();
        $randomCategoryId = fake()->randomElement($categoryIds);

        $userIds = User::pluck('id')->toArray();
        $randomUserId = fake()->randomElement($userIds);
        $title = fake()->sentence(5);
        return [
            "title" => $title,
            "slug" => Str::slug($title),
            "content" => fake()->paragraph(),
            "image" => "article/image-$imageNumber.jpg",
            "category_id" => $randomCategoryId,
            "created_by" => $randomUserId,
            "updated_by" => $randomUserId,
        ];
    }
}
