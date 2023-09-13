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
        $title = fake()->sentence(5);
        return [
            "title" => $title,
            "slug" => Str::slug($title),
            "content" => fake()->paragraph(),
            "image" => "articleImage.jpg",
            "category_id" => $randomCategoryId,
            "created_by" => $randomUserId,
            "updated_by" => $randomUserId,
        ];
    }
}
