<?php

namespace Database\Seeders;

use App\Models\Concentration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConcentrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $concentrations = ["Website", "Desain", "Mobile"];

        foreach ($concentrations as $concentration) {
            Concentration::create([
                "name" => $concentration,
            ]);
        }
    }
}
