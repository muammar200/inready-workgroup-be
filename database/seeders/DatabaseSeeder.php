<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Work;
use App\Models\Agenda;
use App\Models\Member;
use App\Models\Article;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        Category::factory()->count(5)->create();
        Article::factory()->count(5)->create();
        Agenda::factory()->count(5)->create();
        Activity::factory()->count(5)->create();
        $this->call(MajorSeeder::class);
        $this->call(ConcentrationSeeder::class);
        Member::factory()->count(15)->create();
        Work::factory()->count(10)->create();
        Slider::factory()->count(10)->create();
    }
}
