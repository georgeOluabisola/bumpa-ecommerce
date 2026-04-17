<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievement::insert([
            ['name' => 'First Purchase', 'required_purchases' => 1],
            ['name' => '5 Purchases', 'required_purchases' => 5],
            ['name' => '10 Purchases', 'required_purchases' => 10],
        ]);
    }
}
