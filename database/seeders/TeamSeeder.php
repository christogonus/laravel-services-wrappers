<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'name' => 'Chero Fitness',
            'url' => 'https://cherofitness.com',
            'description' => 'Cherofitness is a live training service and personalized meal plan providing service.',
            'niche' => 'Health and Fitness Brand',
        ]);
    }
}
