<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryIds = Category::pluck('id')->toArray();
        $randomCategoryId = fake()->randomElement($categoryIds);

        $userIds = User::pluck('id')->toArray();
        $randomUserId = fake()->randomElement($userIds);
        return [
            "title" => fake()->sentence(5),
            "content" => fake()->paragraph(),
            "image" => "articleImage.jpg",
            "category_id" => $randomCategoryId,
            "user_id" => $randomUserId,
        ];
    }
}
