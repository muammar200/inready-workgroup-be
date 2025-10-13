<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Work;
use App\Models\Agenda;
use App\Models\Member;
use App\Models\Article;
use App\Models\Activity;
use App\Models\BPO;
use App\Models\Category;
use App\Models\Division;
use App\Models\Gallery;
use App\Models\Presidium;
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
        Agenda::factory()->count(25)->create();
        Activity::factory()->count(5)->create();
        $this->call(MajorSeeder::class);
        $this->call(ConcentrationSeeder::class);
        Member::factory()->count(50)->create();
        Work::factory()->count(10)->create();
        Slider::factory()->count(10)->create();
        Gallery::factory()->count(9)->create();

        $data = [
            [
                'name' => 'Ketua Umum',
                'level' => 1,
            ],
            [
                'name' => 'Bendahara Umum',
                'level' => 2,
            ],
            [
                'name' => 'Wakil Bendahara Umum',
                'level' => 3,
            ],
            [
                'name' => 'Sekretaris Umum',
                'level' => 4,
            ],
            [
                'name' => 'Wakil Sekretaris Umum',
                'level' => 5,
            ],
            [
                'name' => 'Wakil Ketua 1',
                'level' => 6,
            ],
            [
                'name' => 'Wakil Ketua 2',
                'level' => 7,
            ],
            [
                'name' => 'Wakil Ketua 3',
                'level' => 8,
            ],
        ];

        foreach ($data as $i) {
            Presidium::create($i);
        }

        foreach(Presidium::where('level', '>', 5)->get() as $pres){
            for($i = 0; $i < rand(2,3); $i++){
                Division::create([
                    'name' => fake()->jobTitle,
                    'presidium_id' => $pres->id
                ]);
            }
        }

        foreach(Member::limit(8)->get() as $i => $member){
            BPO::create([
                'member_id' => $member->id,
                'presidium_id' => $i+1,
            ]);
        }

        foreach(Member::where('id', '>', 8)->get() as $member){
            BPO::create([
                'member_id' => $member->id,
                'division_id' => Division::inRandomOrder()->first()->id,
            ]);
        }

        foreach(Division::all() as $div){
            $bpo = BPO::where('division_id', $div->id)->inRandomOrder()->first();
            $bpo->update(['is_division_head' => true]);
        }
            
    }
}
